<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Notifications\Candidate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Traits\WhatsappNotificationTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AdminPaymentController extends Controller
{

    use WhatsappNotificationTrait;

    public function index(): Response
    {
        $payment = Payment::with('user', 'media')->orderBy('created_at', 'desc')->paginate(10)->through(function ($item) {
            return [
                'id' => $item->id,
                'bank' => $item->bank,
                'account_name' => $item->account_name,
                'account_number' => $item->account_number,
                'amount' => $item->amount,
                'date' => $item->date,
                'image' => $item->getFirstMediaUrl('image') ?? '',
                'type_payment' => $item->type_payment,
                'code' => $item->code,
                'status' => $item->status,
                'note' => $item->note,
                'user' => $item->user->name,
                'prodi' => $item->user->getForm->prodi->only('nama_prodi', 'biaya_registrasi', 'jenjang', 'fakultas') ?? 'Belum diisi',
            ];
        });
        // dd($payment);
        return Inertia::render('Admin/Payment', [
            'payment' => $payment
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $payment->status = $request->status;
        $payment->note = $request->note ?? null;
        $payment->save();

        $user = User::find($payment->user_id);

        $form = $user->getForm;
        if ($request->status === 'approved' && $payment->type_payment == 'form') {
            $form->is_paid_registration = $payment->created_at;

            $no_target = $user->phone;
            $message = "*Selamat!*\nPembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.\n\n~PMB Politeknik Sawunggalih Aji";

            $this->whatsappNotification($no_target, $message);

            $user->notify(
                new Candidate(
                    'Pembayaran',
                    'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
                )
            );
        } else if ($request->status === 'approved' && $payment->type_payment == 'registration') {

            $code_prodi = '';
            $code_entry_year = '';
            $code_class = '';
            $last_digits_nim = '001';

            DB::beginTransaction(); // Mulai transaksi

            try {
                // Check kode prodi
                $prodi = $form->prodi->kode_jurusan;
                if ($prodi) {
                    $code_prodi = $prodi;
                } else {
                    throw new Exception('Kode prodi tidak valid');
                }

                // Check tahun masuk
                $entry_year = $form->wave->tahun_akademik;
                if ($entry_year) {
                    $code_entry_year = substr($entry_year, 2, 2);
                } else {
                    throw new Exception('Tahun masuk tidak valid');
                }

                // Check kelas pilihan
                $class = $form->kelas->nama_kelas;
                $code_class = $class == 'Reguler' ? '1' : '2';

                // Ambil NIM terakhir dari database
                $last_nim_record = DB::table('forms')
                    ->where('nim', 'like', $code_prodi . $code_entry_year . $code_class . '%')
                    ->orderBy('nim', 'desc')
                    ->first();

                if ($last_nim_record) {
                    // Ambil 3 digit terakhir dari NIM terakhir dan tambahkan 1
                    $last_digits_nim = str_pad((int)substr($last_nim_record->nim, -3) + 1, 3, '0', STR_PAD_LEFT);
                }

                // Buat NIM baru
                $nim = $code_prodi . $code_entry_year . $code_class . $last_digits_nim;

                // Set NIM ke form
                $form->nim = $nim;

                // Tandai pendaftaran sebagai telah dibayar
                $form->is_paid_registration = $payment->created_at;

                // Simpan form
                $form->save();

                // Kirim notifikasi ke user

                $prodi = $form->prodi;

                $no_target = $user->phone;
                $message = "*Pembayaran Anda telah diterima!*\nAnda telah berhasil mendaftar sebagai mahasiswa Politeknik Sawunggalih Aji, data Anda sebagai berikut: \n\n*Nama Lengkap:* $user->name\n*NIM:* $form->nim\n*Prodi:* $prodi->nama_prodi \n\n ~PMB Politeknik Sawunggalih Aji";

                $this->whatsappNotification($no_target, $message);

                $user->notify(
                    new Candidate(
                        'Pembayaran',
                        'Selamat, pembayaran Anda telah diterima. Anda telah berhasil mendaftar sebagai mahasiswa Politeknik Sawunggalih Aji'
                    )
                );

                // Commit transaksi
                DB::commit();
            } catch (Exception $e) {
                // Rollback jika terjadi kesalahan
                DB::rollBack();

                // Log atau tampilkan error
                echo 'Terjadi kesalahan: ' . $e->getMessage();
            }
        } else {
            if ($request->status === 'rejected' && ($payment->type_payment == 'form' || $payment->type_payment == 'registration')) {

                $no_target = $form->phone_number;
                $message = "Maaf, pembayaran Anda ditolak.\nSilahkan upload ulang bukti pembayaran!\n\n~PMB Politeknik Sawunggalih Aji";

                $this->whatsappNotification($no_target, $message);

                $user->notify(
                    new Candidate(
                        'Pembayaran',
                        'Maaf, pembayaran Anda ditolak. Silahkan upload ulang bukti pembayaran!'
                    )
                );
            }
            $form->is_paid_registration = null;
        }



        $form->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diubah'
        ]);

        return Redirect::back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $payment->delete();
        return Redirect::back();
    }
}
