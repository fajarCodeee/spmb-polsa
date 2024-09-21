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
            // return [
            //     '',
            //     $item['name'],
            //     "'" . $item['get_form']['national_id'],
            //     $item['get_form']['wave']['tahun_akademik'],
            //     $item['get_form']['address'],
            //     $item['get_form']['prodi']['nama_prodi'],
            //     $item['get_form']['kelas']['nama_kelas'],
            //     $item['get_form']['phone_number'],
            //     $item['get_form']['mother_name'],
            //     $item['email'],
            //     // json_encode($item)  // Tampilkan debug data sebagai JSON
            // ];

            $religion_code = '';
            if ($item['get_form']['religion'] == 'Islam') {
                $religion_code = '1';
            } else  if ($item['get_form']['religion'] == 'Kristen') {
                $religion_code = '2';
            } else  if ($item['get_form']['religion'] == 'Katholik') {
                $religion_code = '3';
            } else if ($item['get_form']['religion'] == 'Hindu') {
                $religion_code = '4';
            } else if ($item['get_form']['religion'] == 'Budha') {
                $religion_code = '5';
            } else if ($item['get_form']['religion'] == 'Khonghucu') {
                $religion_code = '6';
            }

            $amount = null;
            foreach ($item['payments'] as $payment) {
                if ($payment['type_payment'] === 'registration' && $payment['status'] === 'approved') {
                    $amount = $payment['amount'];
                    break;
                }
            }

            return [
                $item['get_form']['nim'] ?? '',
                $item['name'],
                $item['get_form']['birth_place_city'],
                $item['get_form']['birth_date'],
                $item['get_form']['gender'],
                "'" . $item['get_form']['national_id'],
                $religion_code,
                "'" . $item['get_form']['education_number'],
                '12',
                '',
                'INDONESIA',
                '1',
                '',
                '',
                '',
                $item['get_form']['rt'],
                $item['get_form']['rw'],
                '',
                $item['get_form']['address'],
                "'000000",
                $item['get_form']['postal_code'],
                '',
                '',
                '',
                $item['get_form']['phone_number'],
                $item['email'],
                '0',
                '',
                '',
                $item['get_form']['father_name'],
                '',
                '',
                '',
                '',
                '',
                $item['get_form']['mother_name'],
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $item['get_form']['prodi']['kode_jurusan'],
                $item['get_form']['prodi']['nama_prodi'],
                '',
                '',
                '',
                '',
                '',
                '1',
                $amount,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'NIK',
            'Agama',
            'NISN',
            'Jalur Pendaftaran',
            'NPWP',
            'Kewarganegaraan',
            'Jenis Pendaftaran',
            'Tanggal Masuk Kuliah',
            'Mulai Semester',
            'Jalan',
            'RT',
            'RW',
            'Nama Dusun',
            'Kelurahan',
            'Kecamatan',
            'Kode Pos',
            'Jenis Tinggal',
            'Alat Transportasi',
            'Telp Rumah',
            'No HP',
            'Email',
            'Terima KPS',
            'No KPS',
            'NIK Ayah',
            'Nama Ayah',
            'Tanggal Lahir Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Tanggal Lahir Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Nama Wali',
            'Tanggal Lahir Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
            'Kode Prodi',
            'Nama Prodi',
            'SKS Diakui',
            'Kode PT Asal',
            'Nama PT Asal',
            'Kode Prodi Asal',
            'Nama Prodi Asal',
            'Jenis Pembiayaan',
            'Jumlah Biaya Masuk',
        ];
    }
}
