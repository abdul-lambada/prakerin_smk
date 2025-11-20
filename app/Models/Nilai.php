<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'tbl_nilai';
    protected $primaryKey = 'kd_nilai';
    public $timestamps = false;

    protected $fillable = [
        'kd_tempat',
        'nilai',        // nilai lama (opsional, bisa dipakai sebagai total sederhana)
        'nilai_du_di',
        'nilai_sidang',
        'bobot_du_di',
        'bobot_sidang',
        'nilai_akhir',
        'predikat',
        'keterangan',
    ];

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }
}
