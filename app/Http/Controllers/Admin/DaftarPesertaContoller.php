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
        $peserta = User::with('payments', 'getForm', 'getForm.kelas', 'getForm.prodi', 'getForm.wave')
            ->whereRelation('payments', 'type_payment', 'form')
            ->whereRelation('payments', 'status', 'approved')
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
