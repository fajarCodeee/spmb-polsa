<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Payment;
use App\Jobs\SendEmailJob;
use App\Models\WebSettings;
use Illuminate\Http\Request;
use App\Notifications\Candidate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\RedirectResponse;
use App\Jobs\SendNotificationByWhatsApp;
use Illuminate\Support\Facades\Redirect;
use App\Traits\WhatsappNotificationTrait;

class PaymentController extends Controller
{

    use WhatsappNotificationTrait;

    public function index(Request $request): Response
    {
        $user = User::find(auth()->user()->id)->payments()->get();
        return Inertia::render(
            'Form/Payment',
            [
                'payment' => $request->user()->payments->map(function ($payment) {
                    return [
                        ...$payment->toArray(),
                        'image' => $payment->getFirstMediaUrl('image'),
                    ];
                }),
                'user_info' => $user
            ]
        );
    }

    public function store(PaymentRequest $request): RedirectResponse
    {

        $request->validated();
        $web_setting = WebSettings::first();
        $payment = User::find(auth()->user()->id)->payments()->create(
            [
                'bank' => $request->bank,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'amount' => $request->amount,
                'date' => $request->date,
                // 'image' => $imagePath,
                'type_payment' => $request->type_payment,
                'code' => $request->code,
            ]
        );

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $payment->addMedia($request->file('image'))->toMediaCollection('image');
            // mengapa gagal mengupload
        }

        $format_date = date('d/m/Y', strtotime($payment->date));

        $no_target = $web_setting->contact_whatsapp;
        $message = "*[Pembayaran]Menunggu Konfimasi!*\nPembayaran peserta penerimaan mahasiswa baru untuk data sebagai berikut:\n*Kode Pembayaran:* $payment->code\n*Atas nama:* $payment->account_name\n*Tanggal:* $format_date";

        $data = [
            'email' => $web_setting->contact_email,
            'name' => '[Pembayaran]Menunggu Konfirmasi',
            'message' => "Pembayaran peserta penerimaan mahasiswa baru untuk data sebagai berikut:\n*Kode Pembayaran:* $payment->code\n*Atas nama:* $payment->account_name\n*Tanggal:* $format_date"
        ];

        dispatch(new SendEmailJob($data));

        dispatch(new SendNotificationByWhatsApp($no_target, $message));

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diupload'
        ]);



        return Redirect::back();
    }

    public function userDestroy(string $id): RedirectResponse
    {
        // $payment = Payment::find($id);
        $userPayment = Auth::user()->payments()->where('id', $id)->first();
        if ($userPayment && $userPayment->status !== 'approved') {
            $userPayment->delete();
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Pembayaran berhasil dihapus'
            ]);
        }
        return Redirect::back();
    }
}
