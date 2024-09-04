<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wave;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DaftarPesertaContoller extends Controller
{

    protected $tahun_akademik;

    public function index(Request $request)
    {
        $peserta = User::when($request->term, function ($query, $term) {
            $query->where('name', 'LIKE', '%' . $term . '%')
                ->orWhere('email', 'LIKE', '%' . $term . '%');
        })
            ->with('payments', 'getForm', 'getForm.kelas', 'getForm.prodi', 'getForm.wave')
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

    public function export(Request $request)
    {

        dd($request);

        $request->validate([
            'tahun_akademik' => 'required',
        ]);

        $users =  User::with('payments', 'getForm', 'getForm.kelas', 'getForm.prodi', 'getForm.wave')
            ->whereRelation('payments', 'type_payment', 'form')
            ->whereRelation('payments', 'status', 'approved')
            ->latest()
            ->get();

        return Excel::download(new UsersExport($users), 'daftar_mahasiswa_baru_' . time() . '.xlsx');
    }

    public function download($tahun_akademik)
    {
        return Excel::download(new UsersExport($tahun_akademik), 'daftar_mahasiswa_baru' . time() . '.xlsx');
    }
}
