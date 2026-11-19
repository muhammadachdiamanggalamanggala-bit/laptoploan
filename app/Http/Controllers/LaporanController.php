<?php

namespace App\Http\Controllers;

use App\Models\LaporanMasalah;
use App\Models\User;
use App\Notifications\LoanStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = LaporanMasalah::with('user')
            ->when(! $request->user()->isAdmin(), fn ($query) => $query->where('user_id', $request->user()->id))
            ->latest()
            ->paginate(15);

        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function file(Request $request, LaporanMasalah $laporan)
    {
        abort_unless($request->user()->isAdmin() || $laporan->user_id === $request->user()->id, 403);
        abort_unless($laporan->foto && Storage::disk('local')->exists($laporan->foto), 404);

        return Storage::disk('local')->response($laporan->foto);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:160',
            'kategori' => 'required|in:Bug Website,Laptop Bermasalah,Charger Bermasalah,Akun,Peminjaman,Lainnya',
            'deskripsi' => 'required|string|max:5000',
            'foto' => 'nullable|image|max:3072',
            'prioritas' => 'required|in:Rendah,Normal,Tinggi',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('laporan');
        }

        $validated['user_id'] = $request->user()->id;
        $laporan = LaporanMasalah::create($validated);

        Notification::send(
            User::where('role', 'admin')->get(),
            new LoanStatusChanged("Laporan baru: {$laporan->judul}")
        );

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim ke admin.');
    }

    public function update(Request $request, LaporanMasalah $laporan)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai,Ditolak',
            'respon_admin' => 'nullable|string|max:2000',
        ]);

        $laporan->update($validated);
        $laporan->user->notify(new LoanStatusChanged("Status laporan '{$laporan->judul}' diperbarui menjadi {$laporan->status}."));

        return back()->with('success', 'Status laporan diperbarui.');
    }
}