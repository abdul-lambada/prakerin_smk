<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    use HasFactory;

    protected $table = 'tbl_tempat';
    protected $primaryKey = 'kd_tempat';
    public $timestamps = false;

    protected $fillable = [
        'nis_siswa',
        'kd_pembimbing',
        'kd_industri',
        'tanggal',
        'wilayah',
        'tahun',
        'status',
        'surat',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tahun' => 'integer',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis_siswa');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'kd_pembimbing', 'kd_pembimbing');
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'kd_industri', 'kd_industri');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'kd_tempat', 'kd_tempat');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'kd_tempat', 'kd_tempat');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'kd_tempat', 'kd_tempat');
    }

    public function sidang()
    {
        return $this->hasMany(Sidang::class, 'kd_tempat', 'kd_tempat');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'kd_tempat', 'kd_tempat');
    }

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'kd_tempat', 'kd_tempat');
    }

    public function tolak()
    {
        return $this->hasOne(TolakTempat::class, 'kd_tempat', 'kd_tempat');
    }
}
