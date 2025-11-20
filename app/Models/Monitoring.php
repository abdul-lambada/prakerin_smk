<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'tbl_monitoring';
    protected $primaryKey = 'kd_monitoring';
    public $timestamps = false;

    protected $fillable = [
        'kd_tempat',
        'tanggal',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }
}
