<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Carbon\Carbon;

// Controller ini menyiapkan data yang akan ditampilkan pada halaman dashboard.
class DashboardController extends Controller
{
    // Menampilkan dashboard dengan data sesuai jenis pengguna yang sedang masuk.
    public function index()
    {
        $user = request()->user();

        // Pengguna biasa hanya melihat data peminjamannya sendiri.
        if (! $user->isAdmin()) {
            // Ambil lima peminjaman terbaru beserta informasi barangnya.
            $peminjamanTerbaru = Peminjaman::with('barang')->where('user_id', $user->id)->latest()->take(5)->get();
            // Hitung peminjaman milik pengguna berdasarkan statusnya.
            $totalMenunggu = Peminjaman::where('user_id', $user->id)->where('status', 'menunggu')->count();
            $totalDipinjam = Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')->count();
            // Hitung pinjaman yang masih berstatus dipinjam dan sudah melewati tanggal kembali.
            $totalTerlambat = Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')
                ->whereDate('tanggal_kembali_rencana', '<', Carbon::today())->count();

            // Kirim data pengguna biasa ke halaman dashboard.
            return view('dashboard', [
                'isAdmin' => false,
                // Jumlah stok barang yang kondisinya baik.
                'totalStok' => Barang::where('kondisi', 'Baik')->sum('jumlah'),
                'totalMenunggu' => $totalMenunggu,
                'totalDipinjam' => $totalDipinjam,
                'totalTerlambat' => $totalTerlambat,
                'peminjamanTerbaru' => $peminjamanTerbaru,
            ]);
        }

        // Bagian berikut menyiapkan data keseluruhan khusus untuk admin.
        $isAdmin = true;
        $totalBarang = Barang::count();
        $totalStok = Barang::where('kondisi', 'Baik')->sum('jumlah');
        $totalRusak = Barang::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat', 'Rusak'])->count();
        $totalSiswa    = Siswa::count();
        // Hitung jumlah peminjaman untuk setiap status.
        $totalMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $totalDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // Hitung peminjaman yang lewat tanggal kembali dan belum dikembalikan.
        $totalTerlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', Carbon::today())
            ->count();

        // Ambil lima peminjaman terbaru beserta data siswa, barang, dan penggunanya.
        $peminjamanTerbaru = Peminjaman::with(['siswa', 'barang', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Ambil maksimal lima barang dengan stok lima atau kurang, dari stok terendah.
        $barangMenipis = Barang::where('jumlah', '<=', 5)
            ->orderBy('jumlah', 'asc')
            ->take(5)
            ->get();

        // Kirim semua data admin ke halaman dashboard untuk ditampilkan.
        return view('dashboard', compact(
            'isAdmin',
            'totalBarang',
            'totalStok',
            'totalRusak',
            'totalSiswa',
            'totalMenunggu',
            'totalDipinjam',
            'totalDikembalikan',
            'totalTerlambat',
            'peminjamanTerbaru',
            'barangMenipis'
        ));
    }
}