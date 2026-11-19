<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected function casts(): array
    {
        return [
            'includes_charger' => 'boolean',
            'peminjaman_pada' => 'datetime',
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_kembali_aktual' => 'date',
        ];
    }

    protected $fillable = [
        'siswa_id',
        'user_id',
        'barang_id',
        'jumlah',
        'peminjaman_pada',
        'waktu_kembali_rencana',
        'guru_produktif',
        'mata_pelajaran',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'keperluan',
        'status',
        'includes_charger',
        'catatan',
        'kondisi_kembali',
        'catatan_kerusakan',
        'alasan_penolakan',
    ];

    // Relasi: peminjaman ini milik satu siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: peminjaman ini untuk satu barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}