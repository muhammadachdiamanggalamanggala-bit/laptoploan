<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\User;
use App\Notifications\LoanStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Daftar peminjaman aktif (status: menunggu & dipinjam)
    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('peminjaman.saya');
        }

        $cari = $request->input('cari');

        $peminjaman = Peminjaman::with(['siswa', 'barang', 'user'])
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->when($cari, function ($query) use ($cari) {
                $query->where(function ($query) use ($cari) {
                    $query->whereHas('siswa', fn ($q) => $q->where('nama_siswa', 'like', "%{$cari}%"))
                        ->orWhereHas('barang', fn ($q) => $q->where('nama_barang', 'like', "%{$cari}%"));
                });
            })
            ->latest()
            ->get();

        return view('peminjaman.index', compact('peminjaman', 'cari'));
    }

    // Riwayat: peminjaman yang sudah dikembalikan
    public function riwayat(Request $request)
    {
        $cari = $request->input('cari');

        $peminjaman = Peminjaman::with(['siswa', 'barang', 'user'])
            ->when(! $request->user()->isAdmin(), fn ($query) => $query->where('user_id', $request->user()->id))
            ->where('status', 'dikembalikan')
            ->when($cari, function ($query) use ($cari) {
                $query->where(function ($query) use ($cari) {
                    $query->whereHas('siswa', fn ($q) => $q->where('nama_siswa', 'like', "%{$cari}%"))
                        ->orWhereHas('barang', fn ($q) => $q->where('nama_barang', 'like', "%{$cari}%"));
                });
            })
            ->latest()
            ->get();

        return view('peminjaman.riwayat', compact('peminjaman', 'cari'));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama_siswa')->get();
        $barangs = Barang::where('jumlah', '>', 0)->where('kondisi', 'Baik')->orderBy('nama_barang')->get();

        return view('peminjaman.create', compact('siswas', 'barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'nullable|exists:siswas,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        $validated += $this->validateLoanDetails($request, false);
        $peminjamanPada = Carbon::parse($validated['peminjaman_pada']);

        $barang = Barang::findOrFail($request->barang_id);

        if ($validated['jumlah'] > $barang->jumlah) {
            return back()
                ->withInput()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok barang yang tersedia (stok: ' . $barang->jumlah . ').']);
        }

        Peminjaman::create([
            'siswa_id' => $request->input('siswa_id'),
            'barang_id' => $request->barang_id,
            'jumlah' => $validated['jumlah'],
            'peminjaman_pada' => $validated['peminjaman_pada'],
            'waktu_kembali_rencana' => $validated['waktu_kembali_rencana'],
            'tanggal_pinjam' => $peminjamanPada->toDateString(),
            'tanggal_kembali_rencana' => $peminjamanPada->toDateString(),
            'guru_produktif' => $validated['guru_produktif'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'keperluan' => $validated['keperluan'] ?? null,
            'user_id' => $request->user()->id,
            'status' => 'menunggu',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dibuat, menunggu persetujuan.');
    }

    // Setujui peminjaman: status menunggu -> dipinjam, stok barang dikurangi
    public function approve(Peminjaman $peminjaman)
    {
        $result = DB::transaction(function () use ($peminjaman) {
            $peminjaman = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();
            if ($peminjaman->status !== 'menunggu') {
                return 'processed';
            }

            $barang = Barang::whereKey($peminjaman->barang_id)->lockForUpdate()->firstOrFail();
            if ($peminjaman->jumlah > $barang->jumlah) {
                return 'stock';
            }

            $updated = Barang::whereKey($barang->id)->where('jumlah', '>=', $peminjaman->jumlah)
                ->decrement('jumlah', $peminjaman->jumlah);
            if (! $updated) {
                return 'stock';
            }

            $peminjaman->update(['status' => 'dipinjam']);
            return 'ok';
        });

        if ($result === 'processed') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }
        if ($result === 'stock') {
            return back()->with('error', 'Stok laptop tidak mencukupi untuk menyetujui peminjaman ini.');
        }

        $peminjaman->user?->notify(new LoanStatusChanged('Pengajuan peminjaman laptop kamu telah disetujui.'));

        return back()->with('success', 'Peminjaman disetujui dan stok laptop diperbarui.');
    }

    // Kembalikan barang: status dipinjam -> dikembalikan, stok barang ditambah lagi
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'kondisi_kembali' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan_kerusakan' => 'nullable|string|max:1000',
        ]);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Peminjaman ini belum berstatus dipinjam.');
        }

        DB::transaction(function () use ($peminjaman, $validated) {
            $loan = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();
            if ($loan->status !== 'dipinjam') {
                return;
            }

            Barang::whereKey($loan->barang_id)->lockForUpdate()->firstOrFail()
                ->increment('jumlah', $loan->jumlah);
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_kembali_aktual' => now(),
                'kondisi_kembali' => $validated['kondisi_kembali'],
                'catatan_kerusakan' => $validated['catatan_kerusakan'] ?? null,
            ]);

            if ($validated['kondisi_kembali'] !== 'Baik') {
                Barang::whereKey($loan->barang_id)->update(['kondisi' => $validated['kondisi_kembali']]);
            }

            if ($loan->user) {
                $loan->user->notify(new LoanStatusChanged('Laptop telah ditandai dikembalikan.'));
            }
        });

        return back()->with('success', 'Barang berhasil dikembalikan, stok otomatis diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kalau statusnya masih "dipinjam", kembalikan dulu stoknya sebelum dihapus
        if ($peminjaman->status === 'dipinjam') {
            return back()->with('error', 'Peminjaman yang masih berjalan harus dikembalikan terlebih dahulu.');
        }

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function storeFromCatalog(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1|max:20',
            'includes_charger' => 'nullable|boolean',
        ]);
        $validated += $this->validateLoanDetails($request, true);
        $peminjamanPada = Carbon::parse($validated['peminjaman_pada']);

        if ($barang->kondisi !== 'Baik' || $barang->jumlah < 1 || $validated['jumlah'] > $barang->jumlah) {
            return back()->withInput()->withErrors(['jumlah' => 'Laptop tidak tersedia dalam jumlah yang diminta.']);
        }

        $adminUsers = User::where('role', 'admin')->where('is_active', true)->get();
        if ($adminUsers->isEmpty()) {
            return back()->withInput()->withErrors([
                'admin' => 'Pengajuan belum dapat dikirim karena belum ada admin aktif untuk menyetujuinya.',
            ]);
        }

        DB::transaction(function () use ($request, $barang, $validated, $adminUsers, $peminjamanPada) {
            Peminjaman::create([
                'user_id' => $request->user()->id,
                'barang_id' => $barang->id,
                'jumlah' => $validated['jumlah'],
                'peminjaman_pada' => $validated['peminjaman_pada'],
                'waktu_kembali_rencana' => $validated['waktu_kembali_rencana'],
                'tanggal_pinjam' => $peminjamanPada->toDateString(),
                'tanggal_kembali_rencana' => $peminjamanPada->toDateString(),
                'guru_produktif' => $validated['guru_produktif'],
                'mata_pelajaran' => $validated['mata_pelajaran'],
                'keperluan' => $validated['keperluan'],
                'includes_charger' => $request->boolean('includes_charger'),
                'status' => 'menunggu',
            ]);

            $message = "{$request->user()->name} mengajukan {$validated['jumlah']} unit {$barang->nama_barang} dan menunggu persetujuan.";
            Notification::send(
                $adminUsers,
                new LoanStatusChanged($message, route('peminjaman.index', [], false))
            );
        });

        return redirect()->route('peminjaman.saya')->with('success', 'Pengajuan tersimpan dan menunggu persetujuan admin.');
    }

    public function saya(Request $request)
    {
        $peminjaman = Peminjaman::with('barang')->where('user_id', $request->user()->id)->latest()->paginate(12);

        return view('peminjaman.saya', compact('peminjaman'));
    }

    private function validateLoanDetails(Request $request, bool $keperluanRequired): array
    {
        $validated = $request->validate([
            'peminjaman_pada' => 'required|date|after_or_equal:now',
            'waktu_kembali_rencana' => 'required|date_format:H:i',
            'guru_produktif' => ['required', Rule::in(config('peminjaman.guru_produktif'))],
            'mata_pelajaran' => ['required', Rule::in(config('peminjaman.mata_pelajaran'))],
            'keperluan' => [$keperluanRequired ? 'required' : 'nullable', 'string', 'max:1000'],
        ]);

        $peminjamanPada = Carbon::parse($validated['peminjaman_pada']);
        if ($validated['waktu_kembali_rencana'] <= $peminjamanPada->format('H:i')) {
            throw ValidationException::withMessages([
                'waktu_kembali_rencana' => 'Jam pengembalian harus setelah jam peminjaman pada hari yang sama.',
            ]);
        }

        return $validated;
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate(['alasan_penolakan' => 'required|string|max:1000']);
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya pengajuan yang menunggu yang dapat ditolak.');
        }

        $peminjaman->update(['status' => 'ditolak', 'alasan_penolakan' => $validated['alasan_penolakan']]);
        if ($peminjaman->user) {
            $peminjaman->user->notify(new LoanStatusChanged('Pengajuan peminjaman laptop ditolak: '.$validated['alasan_penolakan']));
        }

        return back()->with('success', 'Pengajuan ditolak dan peminjam telah diberi notifikasi.');
    }
}