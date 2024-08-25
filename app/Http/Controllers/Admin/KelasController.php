<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Kelas;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class KelasController extends Controller
{
    public function index(): Response
    {
        $kelas = Kelas::all();
        return Inertia::render('Admin/Kelas', [
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255'
        ]);

        Kelas::where('id', $id)->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return Redirect::back();
    }

    public function destroy($id): RedirectResponse
    {
        Kelas::where('id', $id)->delete();
        return Redirect::back();
    }
}
