<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'tbl_bimbingan';
    protected $primaryKey = 'kd_bimbingan';
    public $timestamps = false;

    protected $fillable = [
        'kd_tempat',
        'nip',
        'nis_siswa',
        'tanggal',
        'judul',
        'catatan',
        'file',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis_siswa');
    }
}
