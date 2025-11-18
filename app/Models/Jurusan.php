<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'tbl_jurusan';
    protected $primaryKey = 'kd_jurusan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'kd_jurusan', 'kd_jurusan');
    }
}
