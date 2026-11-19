@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<h4 class="mb-3">Riwayat Peminjaman</h4>

<div class="card card-shadow mb-3">
    <div class="card-body">
        <form action="{{ route('riwayat') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="cari" class="form-control" placeholder="Cari nama siswa atau nama barang..."
                value="{{ $cari }}">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<div class="card card-shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Peminjaman pada</th>
                        <th>Tgl Kembali (Aktual)</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa?->nama_siswa ?? 'Data Siswa Hilang' }}</td>
                            <td>{{ $item->barang?->nama_barang ?? 'Data Barang Hilang' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->peminjaman_pada?->format('d/m/Y H:i') ?? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>
                                {{ $item->tanggal_kembali_aktual ? \Carbon\Carbon::parse($item->tanggal_kembali_aktual)->format('d-m-Y') : '-' }}
                            </td>
                            <td><div>Guru: {{ $item->guru_produktif ?? '-' }}</div><div>Mata pelajaran: {{ $item->mata_pelajaran ?? '-' }}</div><div>{{ $item->keperluan ?: '-' }}</div></td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection