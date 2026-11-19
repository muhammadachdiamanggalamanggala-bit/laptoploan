@extends('layouts.app')
@section('title', 'Detail Laptop')
@section('content')
<div class="mb-3"><a href="{{ route('katalog') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kembali ke katalog</a></div>
<div class="row g-4 align-items-start">
    <div class="col-lg-6"><div class="detail-visual">@if($barang->foto)<img src="{{ asset('storage/'.$barang->foto) }}" alt="{{ $barang->nama_barang }}">@else<i class="bi bi-laptop"></i>@endif</div></div>
    <div class="col-lg-6"><div class="eyebrow">{{ $barang->merk ?: 'Laptop sekolah' }} {{ $barang->model }}</div><h1 class="display-6 fw-bold">{{ $barang->nama_barang }}</h1><p class="text-secondary">Kode {{ $barang->kode_barang }} @if($barang->nomor_seri)· Seri {{ $barang->nomor_seri }}@endif</p>
        <div class="detail-facts"><div><span>Kondisi</span><strong>{{ $barang->kondisi }}</strong></div><div><span>Total unit</span><strong>{{ $barang->stok }}</strong></div><div><span>Stok tersedia</span><strong>{{ $barang->jumlah }}</strong></div><div><span>Status</span><strong>{{ $barang->status }}</strong></div></div>
        @if($barang->keterangan)<p class="text-secondary mt-3">{{ $barang->keterangan }}</p>@endif
        @auth
            @if($barang->jumlah > 0 && $barang->kondisi === 'Baik')
            <form method="POST" action="{{ route('katalog.pinjam', $barang) }}" class="loan-form mt-4">
                @csrf
                <h2 class="h5 fw-bold">Ajukan peminjaman</h2>
                @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                <div class="row g-3">
                    <div class="col-6"><label class="form-label" for="jumlah">Jumlah</label><input id="jumlah" class="form-control" type="number" name="jumlah" min="1" max="{{ min(20, $barang->jumlah) }}" value="{{ old('jumlah', 1) }}" required></div>
                    <div class="col-6"><label class="form-label" for="peminjaman_pada">Peminjaman pada</label><input id="peminjaman_pada" class="form-control" type="datetime-local" name="peminjaman_pada" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('peminjaman_pada', now()->format('Y-m-d\TH:i')) }}" required></div>
                    <div class="col-12"><label class="form-label" for="waktu_kembali_rencana">Jam pengembalian</label><input id="waktu_kembali_rencana" class="form-control" type="time" name="waktu_kembali_rencana" value="{{ old('waktu_kembali_rencana') }}" required><small class="form-text">Peminjaman dibatasi dalam satu hari, jadi jam pengembalian harus setelah jam peminjaman.</small></div>
                    <div class="col-md-6"><label class="form-label" for="guru_produktif">Guru Produktif</label><select id="guru_produktif" name="guru_produktif" class="form-select" required><option value="">Pilih guru produktif</option>@foreach(config('peminjaman.guru_produktif') as $guru)<option value="{{ $guru }}" @selected(old('guru_produktif') === $guru)>{{ $guru }}</option>@endforeach</select></div>
                    <div class="col-md-6"><label class="form-label" for="mata_pelajaran">Mata Pelajaran</label><select id="mata_pelajaran" name="mata_pelajaran" class="form-select" required><option value="">Pilih mata pelajaran</option>@foreach(config('peminjaman.mata_pelajaran') as $mataPelajaran)<option value="{{ $mataPelajaran }}" @selected(old('mata_pelajaran') === $mataPelajaran)>{{ $mataPelajaran }}</option>@endforeach</select></div>
                    <div class="col-12"><label class="form-label" for="keperluan">Keperluan</label><textarea id="keperluan" class="form-control" name="keperluan" rows="2" maxlength="1000" required>{{ old('keperluan') }}</textarea></div>
                    <div class="col-12"><label class="form-check"><input class="form-check-input" type="checkbox" name="includes_charger" value="1" @checked(old('includes_charger'))><span class="form-check-label">Sertakan charger</span></label></div>
                </div>
                <button class="btn btn-primary w-100 mt-3"><i class="bi bi-send me-1"></i> Ajukan Peminjaman</button>
            </form>
            @else<div class="alert alert-warning mt-4">Laptop sedang tidak tersedia untuk dipinjam.</div>@endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary mt-4"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk untuk meminjam</a>
        @endauth
    </div>
</div>
@endsection
