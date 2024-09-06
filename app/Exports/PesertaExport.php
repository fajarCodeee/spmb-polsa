<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $filteredData;

    public function __construct($filteredData)
    {
        Log::info('Filtered Data:', $filteredData ?? []);
        $this->filteredData = $filteredData;
    }

    public function collection()
    {
        return collect($this->filteredData)->map(function ($item) {
            return [
                $item['name'],
                "'".$item['get_form']['national_id'],
                $item['get_form']['wave']['tahun_akademik'],
                $item['get_form']['address'],
                $item['get_form']['prodi']['nama_prodi'],
                $item['get_form']['kelas']['nama_kelas'],
                $item['get_form']['phone_number'],
                $item['get_form']['mother_name'],
                $item['email'],
                // json_encode($item)  // Tampilkan debug data sebagai JSON
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'Tahun Akademik',
            'Alamat',
            'Prodi Pilihan',
            'Kelas',
            'Nomer WhatsApp',
            'Nama Ibu',
            'Email'
        ];
    }
}
