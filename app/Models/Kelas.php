<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tbl_kelas';
    protected $primaryKey = 'kd_kelas';
    public $timestamps = false;

    protected $fillable = [
        'kd_jurusan',
        'nama',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'kd_jurusan', 'kd_jurusan');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kd_kelas', 'kd_kelas');
    }
}
