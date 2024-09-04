<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {

        return $this->users->map(function ($user) {
            return [
                'Nama' => $user->name,
                'Email' => $user->email,
                // 'Tahun Akademik' => $user->gelombangPendaftaran->tahun_akademik,
                // Kolom lainnya yang ingin Anda tampilkan
            ];
        });


        // $tahunAjaran = $this->tahun_ajaran;

        // return User::with([
        //     'payments' => function ($query) {
        //         $query->where('type_payment', 'form')
        //             ->where('status', 'approved');
        //     },
        //     'getForm' => function ($query) use ($tahunAjaran) {
        //         $query->with([
        //             'kelas',
        //             'prodi',
        //             'wave' => function ($query) use ($tahunAjaran) {
        //                 $query->where('tahun_akademik', $tahunAjaran);
        //             }
        //         ]);
        //     }
        // ])
        //     ->where('roles', "[\"user\"]")
        //     ->latest()
        //     ->get();
    }
}
