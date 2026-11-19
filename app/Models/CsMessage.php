<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsMessage extends Model
{
    use HasFactory;

    protected $table = 'cs_messages';

    protected $fillable = [
        'nama', 'email', 'whatsapp', 'subjek',
        'id_pembelian', 'pesan', 'user_id', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id_pembelian');
    }
}
