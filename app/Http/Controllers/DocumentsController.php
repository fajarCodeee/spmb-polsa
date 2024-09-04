<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DocumentRequest;
use App\Models\User;

class DocumentsController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        $form = auth()->user()->getForm;
        return Inertia::render('Documents/Index', [
            'ktp' => $form->getFirstMedia('ktp')?->getUrl() ?? null,
            'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
            'ijazah' => $form->getFirstMedia('ijazah')?->getUrl() ?? null,
            'kartu_keluarga' => $form->getFirstMedia('kartu_keluarga')?->getUrl() ?? null,
        ]);
    }

    public function update(DocumentRequest $request): RedirectResponse
    {
        $form = auth()->user()->getForm;
        if ($request->hasFile('ktp') && $request->file('ktp')->isValid()) {
            $form->addMedia($request->file('ktp'))->toMediaCollection('ktp');
        }

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $form->addMedia($request->file('foto'))->toMediaCollection('foto');
        }

        if ($request->hasFile('ijazah') && $request->file('ijazah')->isValid()) {
            $form->addMedia($request->file('ijazah'))->toMediaCollection('ijazah');
        }

        if ($request->hasFile('kartu_keluarga') && $request->file('kartu_keluarga')->isValid()) {
            $form->addMedia($request->file('kartu_keluarga'))->toMediaCollection('kartu_keluarga');
        }

        return Redirect::route('documents.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $documents = $user->getForm->documents;
        $documents->update([
            $request->name => null
        ]);

        return Redirect::route('documents.index');
    }
}
