<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    protected $table = 'laporan_masalah';

    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'deskripsi',
        'foto',
        'prioritas',
        'status',
        'respon_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}