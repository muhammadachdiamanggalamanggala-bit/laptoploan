@extends('layouts.app')
@section('title', 'Katalog Laptop')
@section('content')
<div class="catalog-heading mb-4"><div><div class="text-uppercase small fw-bold text-info-emphasis mb-2">Perangkat sekolah</div><h1 class="h2 fw-bold mb-1">Katalog Laptop</h1><p class="text-secondary mb-0">Cari perangkat yang tersedia dan ajukan peminjaman.</p></div><span class="catalog-count">{{ $barangs->total() }} perangkat</span></div>
<form method="GET" action="{{ route('katalog') }}" class="catalog-filters mb-4">
    <div class="input-group"><span class="input-group-text bg-white"><i class="bi bi-search"></i></span><input name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Nama, merk, model, kode, atau nomor seri"></div>
    <select class="form-select" name="merk"><option value="">Semua merk</option>@foreach($merks as $merk)<option value="{{ $merk }}" @selected(request('merk') === $merk)>{{ $merk }}</option>@endforeach</select>
    <select class="form-select" name="kondisi"><option value="">Semua kondisi</option>@foreach(['Baik','Rusak Ringan','Rusak Berat','Maintenance'] as $kondisi)<option value="{{ $kondisi }}" @selected(request('kondisi') === $kondisi)>{{ $kondisi }}</option>@endforeach</select>
    <label class="form-check filter-available"><input class="form-check-input" type="checkbox" name="tersedia" value="1" @checked(request()->boolean('tersedia'))><span class="form-check-label">Tersedia saja</span></label>
    <button class="btn btn-primary"><i class="bi bi-sliders me-1"></i> Terapkan</button>
</form>
<div class="row g-3">
@forelse($barangs as $barang)
    <div class="col-sm-6 col-xl-4"><article class="laptop-card h-100">
        <a href="{{ route('katalog.show', $barang) }}" class="laptop-visual" aria-label="Detail {{ $barang->nama_barang }}">
            @if($barang->foto)<img src="{{ asset('storage/'.$barang->foto) }}" alt="{{ $barang->nama_barang }}">@else<div class="laptop-placeholder"><i class="bi bi-laptop"></i><span>{{ $barang->merk ?: 'Laptop sekolah' }}</span></div>@endif
            <span class="status-pill {{ $barang->jumlah > 0 && $barang->kondisi === 'Baik' ? 'is-available' : 'is-unavailable' }}">{{ $barang->jumlah > 0 && $barang->kondisi === 'Baik' ? 'Tersedia' : 'Tidak tersedia' }}</span>
        </a>
        <div class="p-3 p-lg-4"><div class="small text-secondary">{{ $barang->merk ?: 'Laptop' }} {{ $barang->model }}</div><h2 class="h5 fw-bold mt-1 mb-2">{{ $barang->nama_barang }}</h2><div class="d-flex justify-content-between align-items-center mb-3"><span class="small text-secondary">{{ $barang->kode_barang }} · {{ $barang->kondisi }}</span><strong class="small">{{ $barang->jumlah }} tersedia</strong></div>
        <a href="{{ route('katalog.show', $barang) }}" class="btn btn-outline-primary w-100">Detail & pinjam <i class="bi bi-arrow-right ms-1"></i></a></div>
    </article></div>
@empty
    <div class="col-12"><div class="empty-catalog"><i class="bi bi-search"></i><h2 class="h5">Laptop tidak ditemukan</h2><p class="text-secondary mb-0">Coba kata kunci atau filter yang berbeda.</p></div></div>
@endforelse
</div>
<div class="mt-4">{{ $barangs->links() }}</div>
@endsection
