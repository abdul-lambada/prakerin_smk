<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'tbl_siswa';
    protected $primaryKey = 'nis_siswa';
    public $timestamps = false;

    protected $fillable = [
        'kd_kelas',
        'user_id',
        'nama_lengkap',
        'telp',
        'foto',
        'kd_pembimbing',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kd_kelas', 'kd_kelas');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'kd_pembimbing', 'kd_pembimbing');
    }

    public function tempat()
    {
        return $this->hasMany(Tempat::class, 'nis_siswa', 'nis_siswa');
    }
}
