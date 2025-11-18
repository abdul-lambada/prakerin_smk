<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $table = 'tbl_info';
    protected $primaryKey = 'kd_info';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'tanggal',
        'kategori',
        'file',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
