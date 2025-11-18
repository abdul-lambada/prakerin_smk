<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TolakTempat extends Model
{
    use HasFactory;

    protected $table = 'tbl_tolak_tempat';
    protected $primaryKey = 'kd_tolak';
    public $timestamps = false;

    protected $fillable = [
        'kd_tempat',
        'tanggal',
        'alasan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }
}
