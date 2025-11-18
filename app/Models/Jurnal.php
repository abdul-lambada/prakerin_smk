<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'tbl_jurnal';
    protected $primaryKey = 'kd_jurnal';
    public $timestamps = false;

    protected $fillable = [
        'nis_siswa',
        'kd_tempat',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kegiatan',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis_siswa');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }
}
