<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'merk',
        'model',
        'nomor_seri',
        'foto',
        'stok',
        'jumlah',
        'kondisi',
        'keterangan',
    ];

    public function getStatusAttribute(): string
    {
        if (in_array($this->kondisi, ['Rusak Ringan', 'Rusak Berat', 'Rusak'], true)) {
            return 'Rusak';
        }

        if ($this->kondisi === 'Maintenance') {
            return 'Maintenance';
        }

        return $this->jumlah > 0 ? 'Tersedia' : 'Sedang Dipinjam';
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }
}