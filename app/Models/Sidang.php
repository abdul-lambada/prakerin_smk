<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    use HasFactory;

    protected $table = 'tbl_sidang';
    protected $primaryKey = 'kd_sidang';
    public $timestamps = false;

    protected $fillable = [
        'nis_siswa',
        'kd_tempat',
        'kd_industri',
        'judul',
        'file',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis_siswa');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'kd_industri', 'kd_industri');
    }
}
