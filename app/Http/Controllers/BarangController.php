<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function katalog(Request $request)
    {
        $barangs = Barang::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $term = $request->string('cari')->toString();
                $query->where(function ($query) use ($term) {
                    $query->where('nama_barang', 'like', "%{$term}%")
                        ->orWhere('kode_barang', 'like', "%{$term}%")
                        ->orWhere('merk', 'like', "%{$term}%")
                        ->orWhere('model', 'like', "%{$term}%")
                        ->orWhere('nomor_seri', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('merk'), fn ($query) => $query->where('merk', $request->input('merk')))
            ->when($request->filled('kondisi'), fn ($query) => $query->where('kondisi', $request->input('kondisi')))
            ->when($request->boolean('tersedia'), fn ($query) => $query->where('jumlah', '>', 0)->where('kondisi', 'Baik'))
            ->orderBy('nama_barang')
            ->paginate(12)
            ->withQueryString();

        $merks = Barang::whereNotNull('merk')->where('merk', '!=', '')->distinct()->orderBy('merk')->pluck('merk');

        return view('barang.katalog', compact('barangs', 'merks'));
    }

    public function detail(Barang $barang)
    {
        return view('barang.detail', compact('barang'));
    }

    public function index(Request $request)
    {
        $cari = $request->input('cari');

        $barangs = Barang::when($cari, function ($query) use ($cari) {
            $query->where(function ($query) use ($cari) {
                $query->where('nama_barang', 'like', "%{$cari}%")
                ->orWhere('kode_barang', 'like', "%{$cari}%")
                ->orWhere('merk', 'like', "%{$cari}%")
                ->orWhere('model', 'like', "%{$cari}%")
                ->orWhere('nomor_seri', 'like', "%{$cari}%");
            });
            })
            ->latest()
            ->get();

        return view('barang.index', compact('barangs', 'cari'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang',
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'nomor_seri' => 'nullable|string|max:100',
            'foto' => 'nullable|image|max:3072',
            'jumlah' => 'required|integer|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Maintenance',
            'keterangan' => 'nullable|string',
        ]);

        $foto = $request->file('foto')?->store('laptop', 'public');

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'merk' => $request->merk,
            'model' => $request->model,
            'nomor_seri' => $request->nomor_seri,
            'foto' => $foto,
            'stok' => $request->jumlah,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang,' . $barang->id,
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'nomor_seri' => 'nullable|string|max:100',
            'foto' => 'nullable|image|max:3072',
            'jumlah' => 'required|integer|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Maintenance',
            'keterangan' => 'nullable|string',
        ]);

        $dipinjam = $barang->stok - $barang->jumlah;
        if ($request->jumlah < $dipinjam) {
            return back()->withInput()->withErrors(['jumlah' => "Total stok tidak boleh di bawah {$dipinjam} unit yang sedang dipinjam."]);
        }

        $foto = $barang->foto;
        if ($request->hasFile('foto')) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }
            $foto = $request->file('foto')->store('laptop', 'public');
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'merk' => $request->merk,
            'model' => $request->model,
            'nomor_seri' => $request->nomor_seri,
            'foto' => $foto,
            'stok' => $request->jumlah,
            'jumlah' => $request->jumlah - $dipinjam,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}