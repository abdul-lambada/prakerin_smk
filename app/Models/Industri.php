<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    use HasFactory;

    protected $table = 'tbl_industri';
    protected $primaryKey = 'kd_industri';
    public $timestamps = false;

    protected $fillable = [
        'nama_industri',
        'bidang_kerja',
        'deskripsi',
        'alamat_industri',
        'wilayah',
        'telepon',
        'kuota',
        'foto',
    ];

    public function tempat()
    {
        return $this->hasMany(Tempat::class, 'kd_industri', 'kd_industri');
    }
}
