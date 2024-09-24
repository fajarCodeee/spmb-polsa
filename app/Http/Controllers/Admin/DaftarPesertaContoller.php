<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Wave;

class DaftarPesertaContoller extends Controller
{

    protected $tahun_akademik;

    public function index()
    {
        $peserta = User::with(['payments', 'getForm.kelas', 'getForm.prodi', 'getForm.wave'])
            ->whereHas('payments', function ($query) {
                $query->where('type_payment', 'form')
                    ->where('status', 'approved');
            })->whereHas('getForm', function ($query) {
                $query->where('nim', '');
            })
            ->latest()
            ->get();

        $wave = Wave::select('tahun_akademik')
            ->distinct()
            ->get();

        return Inertia::render('Admin/DaftarPeserta', [
            'peserta' => $peserta,
            'wave' => $wave
        ]);
    }

    public function laporanAll()
    {
        $peserta = User::with(['payments', 'getForm.kelas', 'getForm.prodi', 'getForm.wave'])
            ->whereHas('payments', function ($query) {
                $query->where('type_payment', 'registration')
                    ->where('status', 'approved');
            })
            ->latest()
            ->get();

        $wave = Wave::select('tahun_akademik')
            ->distinct()
            ->get();

        return Inertia::render('Admin/DaftarPeserta', [
            'peserta' => $peserta,
            'wave' => $wave
        ]);
    }
}
