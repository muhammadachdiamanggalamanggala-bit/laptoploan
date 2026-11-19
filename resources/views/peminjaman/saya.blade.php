@extends('layouts.app')
@section('title', 'Peminjaman Saya')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4"><div><div class="text-uppercase small fw-bold text-info-emphasis mb-1">Akun peminjam</div><h1 class="h2 fw-bold mb-1">Peminjaman Saya</h1><p class="text-secondary mb-0">Pantau pengajuan, masa pinjam, dan status pengembalian laptop.</p></div><a href="{{ route('katalog') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Pinjam laptop</a></div>
<div class="table-responsive bg-body rounded-4 border"><table class="table align-middle mb-0"><thead><tr><th>Laptop</th><th>Peminjaman pada</th><th>Pengembalian pada</th><th>Guru Produktif</th><th>Mata Pelajaran</th><th>Keperluan</th><th>Status</th><th>Paket</th></tr></thead><tbody>
@forelse($peminjaman as $item)
<tr><td><div class="fw-semibold">{{ $item->barang->nama_barang ?? 'Laptop dihapus' }}</div><div class="small text-secondary">{{ $item->barang->kode_barang ?? '-' }} · {{ $item->jumlah }} unit</div></td><td>{{ $item->peminjaman_pada?->format('d/m/Y H:i') ?? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td><td>{{ $item->waktu_kembali_rencana ? \Carbon\Carbon::parse($item->waktu_kembali_rencana)->format('H:i') : '-' }}</td><td>{{ $item->guru_produktif ?? '-' }}</td><td>{{ $item->mata_pelajaran ?? '-' }}</td><td>{{ $item->keperluan ?: '-' }}</td><td><span class="badge text-bg-{{ ['menunggu'=>'warning','dipinjam'=>'primary','dikembalikan'=>'success','ditolak'=>'danger'][$item->status] ?? 'secondary' }}">{{ ucfirst($item->status) }}</span></td><td>{{ $item->includes_charger ? 'Laptop + charger' : 'Laptop saja' }}</td></tr>
@empty<tr><td colspan="8" class="text-center py-5"><i class="bi bi-inbox fs-2 d-block text-secondary mb-2"></i>Belum ada pengajuan peminjaman.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $peminjaman->links() }}</div>
@endsection
