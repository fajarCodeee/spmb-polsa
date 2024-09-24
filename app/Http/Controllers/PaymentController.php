<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PaymentRequest;
use App\Models\WebSettings;
use App\Notifications\Candidate;
use App\Traits\WhatsappNotificationTrait;
use Illuminate\Support\Facades\Auth;

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
        $message = "*[Pembayaran]Menunggu Konfimasi!*, pembayaran peserta penerimaan mahasiswa baru untuk data sebagai berikut:\n*Kode Pembayaran:* $payment->code\n*Atas nama:* $payment->account_name\n*Tanggal:* $format_date";

        $this->whatsappNotification($no_target, $message);

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
