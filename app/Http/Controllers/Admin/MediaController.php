<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\WebSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MediaController extends Controller
{
    public function index()
    {
        $web_setting = WebSettings::first();
        return Inertia::render('Admin/Media', [
            'brosur' => $web_setting->getFirstMedia('brosur')?->getUrl() ?? null,
            'rincian_biaya' => $web_setting->getFirstMedia('rincian_biaya')?->getUrl() ?? null
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'brosur' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'nullable'],
            'rincian_biaya' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'nullable'],
        ]);

        $web_setting = WebSettings::first();

        if ($request->hasFile('brosur') && $request->file('brosur')->isValid()) {
            $web_setting
                ->addMedia($request->file('brosur'))
                ->usingFileName('brosur.' . $request->file('brosur')->getClientOriginalExtension())
                ->toMediaCollection('brosur');
        }

        if ($request->hasFile('rincian_biaya') && $request->file('rincian_biaya')->isValid()) {
            $web_setting
                ->addMedia($request->file('rincian_biaya'))
                ->usingFileName('rincian_biaya.' . $request->file('rincian_biaya')->getClientOriginalExtension())
                ->toMediaCollection('rincian_biaya');
        }

        return Redirect::route('admin.media');
    }
}
