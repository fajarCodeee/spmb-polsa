<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = ['nama_kelas'];

    public function getKelas()
    {
        return $this->hasMany(Form::class);
    }

    public static function getKelasById($id)
    {
        return static::where('id', $id)->first() ?: null;
    }
}
