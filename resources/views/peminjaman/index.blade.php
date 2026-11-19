@extends('layouts.app')
@section('title', 'Kelola Peminjaman')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4"><div><div class="text-uppercase small fw-bold text-info-emphasis mb-1">Panel admin</div><h1 class="h3 fw-bold mb-1">Kelola Peminjaman Laptop</h1><p class="text-secondary mb-0">Tinjau pengajuan, ubah keputusan, dan catat kondisi pengembalian.</p></div><a href="{{ route('peminjaman.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Pengajuan</a></div>
<form action="{{ route('peminjaman.index') }}" method="GET" class="input-group mb-3"><span class="input-group-text bg-body"><i class="bi bi-search"></i></span><input type="search" name="cari" class="form-control" placeholder="Cari peminjam atau laptop..." value="{{ $cari }}"><button class="btn btn-outline-primary">Cari</button></form>
<div class="table-responsive bg-body rounded-4 border"><table class="table align-middle mb-0"><thead><tr><th>Peminjam</th><th>Laptop</th><th>Peminjaman pada</th><th>Pengembalian pada</th><th>Detail keperluan</th><th>Status</th><th style="min-width:260px">Tindakan</th></tr></thead><tbody>
@forelse($peminjaman as $item)
<tr><td><div class="fw-semibold">{{ $item->user->name ?? $item->siswa->nama_siswa ?? 'Admin' }}</div><small class="text-secondary">{{ $item->user->email ?? $item->siswa->kelas ?? '-' }}</small></td><td><div class="fw-semibold">{{ $item->barang->nama_barang ?? 'Laptop dihapus' }}</div><small class="text-secondary">{{ $item->barang->kode_barang ?? '-' }} · {{ $item->jumlah }} unit</small></td><td>{{ $item->peminjaman_pada?->format('d/m/Y H:i') ?? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td><td>{{ $item->waktu_kembali_rencana ? \Carbon\Carbon::parse($item->waktu_kembali_rencana)->format('H:i') : '-' }}</td><td><div><span class="fw-semibold">Guru:</span> {{ $item->guru_produktif ?? '-' }}</div><div><span class="fw-semibold">Mata pelajaran:</span> {{ $item->mata_pelajaran ?? '-' }}</div><div>{{ $item->keperluan ?: '-' }}</div></td><td><span class="badge text-bg-{{ $item->status === 'menunggu' ? 'warning' : 'primary' }}">{{ ucfirst($item->status) }}</span></td><td>
<div class="d-flex flex-column gap-2">
@if($item->status === 'menunggu')
<form action="{{ route('peminjaman.approve', $item) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Setujui dan kurangi stok</button></form>
<form action="{{ route('peminjaman.reject', $item) }}" method="POST" class="d-flex gap-1">@csrf @method('PATCH')<input name="alasan_penolakan" class="form-control form-control-sm" placeholder="Alasan penolakan" required><button class="btn btn-sm btn-outline-danger">Tolak</button></form>
@elseif($item->status === 'dipinjam')
<form action="{{ route('peminjaman.kembalikan', $item) }}" method="POST" class="d-flex flex-wrap gap-1">@csrf @method('PATCH')<select name="kondisi_kembali" class="form-select form-select-sm" required><option value="Baik">Baik</option><option value="Rusak Ringan">Rusak ringan</option><option value="Rusak Berat">Rusak berat</option></select><input name="catatan_kerusakan" class="form-control form-control-sm" placeholder="Catatan kerusakan (opsional)"><button class="btn btn-sm btn-primary" onclick="return confirm('Catat laptop sudah dikembalikan?')"><i class="bi bi-box-arrow-in-left me-1"></i>Kembalikan</button></form>
@endif
</div></td></tr>
@empty<tr><td colspan="7" class="text-center py-5"><i class="bi bi-inbox fs-2 d-block text-secondary mb-2"></i>Tidak ada pengajuan aktif.</td></tr>@endforelse
</tbody></table></div>
@endsection
