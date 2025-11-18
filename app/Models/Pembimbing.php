<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'tbl_pembimbing';
    protected $primaryKey = 'kd_pembimbing';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'kd_jurusan',
        'nip',
        'nama_lengkap',
        'wilayah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kd_pembimbing', 'kd_pembimbing');
    }

    public function tempat()
    {
        return $this->hasMany(Tempat::class, 'kd_pembimbing', 'kd_pembimbing');
    }
}
