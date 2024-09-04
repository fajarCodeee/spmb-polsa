<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\WebSettingsRequest;
use App\Models\WebSettings;

class WebSettingController extends Controller
{
    public function index(): Response
    {
        // dd(WebSettings::first());

        return Inertia::render('Admin/WebSetting', [
            'webSettings' => WebSettings::first()
        ]);
    }

    public function update(WebSettingsRequest $request): RedirectResponse
    {
        $webSettings = WebSettings::first();

        $validateData = $request->validated();

        dd($validateData);

        $updateData = [
            'name' => $validateData->name,
            'title_home' => $validateData['title_home'],
            'title_dashboard' => $validateData['title_dashboard'],
            'institution_short_name' => $validateData['institution_short_name'],
            'institution_synopsis' => $validateData['institution_synopsis'],
            'institution_vision_mission' => $validateData['institution_vision_mission'],
            'institution_history' => $validateData['institution_history'],
            'title_exam' => $validateData['title_exam'],
            'footer' => $validateData['footer'],
            'payment_bank' => $validateData['payment_bank'],
            'paymnet_account' => $validateData['paymnet_account'],
            'payment_name' => $validateData['payment_name'],
            'contact_telp' => $validateData['contact_telp'],
            'contact_email' => $validateData['contact_email'],
            'contact_fax' => $validateData['contact_fax'],
            'contact_address' => $validateData['contact_address'],
            'contact_maps' => $validateData['contact_maps'],
            'contact_facebook' => $validateData['contact_facebook'],
            'contact_whatsapp' => $validateData['contact_whatsapp'],
            'contact_instagram' => $validateData['contact_instagram'],
            'contact_twitter' => $validateData['contact_twitter'],
            'contact_youtube' => $validateData['contact_youtube'],
            'link_univ' => $validateData['link_univ'],
        ];

        if ($request->hasFile('path_brosur') && $request->file('path_brosur')->isValid()) {
            $webSettings->addMedia($request->file('path_brosur'))->toMediaCollection('path_brosur');
        }

        if ($request->hasFile('path_rincian_harga') && $request->file('path_rincian_harga')->isValid()) {
            $webSettings->addMedia($request->file('path_rincian_harga'))->toMediaCollection('path_rincian_harga');
        }

        $webSettings->update($updateData);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);

        return redirect()->back();
    }

    public function backup(): RedirectResponse
    {
        Artisan::call('backup:run');

        $output = Artisan::output();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Backup database berhasil dilakukan'
        ]);

        return redirect()->back();
    }
}
