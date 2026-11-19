<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'jurusan',
    ];

    // Relasi: satu siswa bisa punya banyak peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}