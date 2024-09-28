<?php

namespace App\Http\Controllers\Admin;

use App\Models\Form;
use App\Models\User;
use App\Models\Wave;
use Inertia\Inertia;
use App\Models\Prodi;
use Inertia\Response;
use App\Jobs\SendEmailJob;
use App\Helper\StatusHelper;
use Illuminate\Http\Request;
use App\Notifications\Candidate;
use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationByWhatsApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Traits\WhatsappNotificationTrait;

class VerificationController extends Controller
{

    use WhatsappNotificationTrait;

    public function view(): Response
    {
        $form = Form::where('status', 'submitted')->orderBy('created_at', 'desc')->with('user', 'prodi')->paginate(10)->through(function ($form) {
            return [
                'id' => $form->id,
                'user' => $form->user,
                'no_exam' => $form->no_exam,
                'code_registration' => $form->code_registration,
                'wave_id' => $form->wave_id,
                'option' => $form->prodi,
                'is_submitted' => $form->is_submitted,
                'is_paid_registration' => $form->is_paid_registration,
                'status' => $form->status,
                'created_at' => $form->created_at,
                'updated_at' => $form->updated_at,
            ];
        });

        return Inertia::render('Admin/Verification/Index', [
            'forms' => $form
        ]);
    }

    public function index(string $id): Response|RedirectResponse
    {
        $form = Form::with('user', 'prodi', 'wave', 'media')->find($id);
        if (!$form) {
            return redirect()->route('admin.verification');
        }
        return Inertia::render('Admin/Verification/User', [
            'form' => $form,
            'user' => $form->user,
            'prodi' => $form->prodi,
            'wave' => $form->wave,
            'image' => [
                'ktp' => $form->getFirstMedia('ktp')?->getUrl() ?? null,
                'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
                'ijazah' => $form->getFirstMedia('ijazah')?->getUrl() ?? null,
                'kartu_keluarga' => $form->getFirstMedia('kartu_keluarga')?->getUrl() ?? null,
            ]
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected'],
            'note' => ['nullable', 'string'],
            'is_via_online' => ['required', 'boolean'],
            'is_submitted' => ['required', 'boolean'],
        ]);

        $form = Form::with('user')->with('prodi')->with('wave')->find($id);

        if ($request->status == 'approved' && !$form->no_exam) {
            $form->no_exam = $form->wave->code . '-' . $form->prodi->id . '-' . $form->id;
        }
        $form->status = $request->status;
        $form->note = $request->note;
        $form->is_via_online = $request->is_via_online;
        if ($request->status !== 'approved')
            $form->is_lock = false;
        $form->is_submitted = $request->is_submitted;
        $form->save();

        $no_target = $form->user->phone;
        $message = "*Selamat!*\nFormulir anda telah disetujui oleh panitia. Silahkan cek untuk melanjutkan proses pendaftaran.\n\n~PMB Politeknik Sawunggalih Aji";

        $data = [
            'email' => $form->user->email,
            'name' => 'Pendaftaran',
            'body' => 'Selamat, formulir anda telah disetujui oleh panitia. Silahkan cek untuk melanjutkan proses pendaftaran.'
        ];

        dispatch(new SendEmailJob($data));
        dispatch(new SendNotificationByWhatsApp($no_target, $message));

        $form->user->notify(
            new Candidate(
                'Pendaftaran',
                'Formulir anda ' . StatusHelper::getStatus($request->status) . ' oleh panitia'
            )
        );

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Formulir berhasil di ubah'
        ]);

        return redirect()->back();
    }
}
