@extends('layouts.app')

@section('title', 'Data Laptop')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h1 class="h3 fw-bold mb-1">Data Laptop</h1><p class="text-secondary mb-0">Kelola inventaris dan ketersediaan perangkat.</p></div>

    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Laptop
    </a>
</div>

<div class="card card-shadow mb-3">
    <div class="card-body">
        <form action="{{ route('barang.index') }}" method="GET" class="d-flex gap-2">

            <input
                type="text"
                name="cari"
                class="form-control"
                placeholder="Cari nama, kode, merk, model, atau nomor seri..."
                value="{{ $cari ?? '' }}"
            >

            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-search"></i>
            </button>

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
                        <th>Laptop</th>
                        <th>Kode</th>
                        <th>Total</th>
                        <th>Tersedia</th>
                        <th>Kondisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($barangs as $barang)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td><div class="fw-semibold">{{ $barang->nama_barang }}</div><small class="text-secondary">{{ $barang->merk }} {{ $barang->model }}</small></td>

                            <td>{{ $barang->kode_barang }}</td>

                            <td>{{ $barang->stok }}</td>
                            <td><span class="badge text-bg-{{ $barang->jumlah > 0 ? 'success' : 'warning' }}">{{ $barang->jumlah }}</span></td>

                            <td>
                                @php
                                    $badge = match($barang->kondisi) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }}">
                                    {{ $barang->kondisi }}
                                </span>
                            </td>

                            <td>{{ $barang->keterangan ?? '-' }}</td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a
                                        href="{{ route('barang.edit', $barang->id) }}"
                                        class="btn btn-sm btn-success"
                                    >
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('barang.destroy', $barang->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus barang ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada data laptop.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection