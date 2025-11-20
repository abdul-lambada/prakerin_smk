<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDudiPembimbing extends Model
{
    use HasFactory;

    protected $table = 'tbl_chat_dudi_pembimbing';

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'kategori',
        'judul',
        'pesan',
        'kd_tempat',
        'is_read_dudi',
        'is_read_pembimbing',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'kd_tempat', 'kd_tempat');
    }
}
