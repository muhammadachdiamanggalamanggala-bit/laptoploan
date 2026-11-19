@extends('layouts.app')
@section('title', 'Ajukan Peminjaman Laptop')
@section('content')
<div class="mb-4"><a href="{{ route('peminjaman.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kelola Peminjaman</a><h1 class="h3 fw-bold mt-2">Peminjaman Laptop</h1><p class="text-secondary mb-0">Pengajuan baru menunggu persetujuan sebelum stok berkurang.</p></div>
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form action="{{ route('peminjaman.store') }}" method="POST" class="card card-shadow"><div class="card-body p-4">@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label" for="siswa_id">Nama siswa (opsional)</label><select id="siswa_id" name="siswa_id" class="form-select"><option value="">Peminjam akun/admin</option>@foreach($siswas as $siswa)<option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>{{ $siswa->nama_siswa }} · {{ $siswa->kelas }}</option>@endforeach</select></div>
    <div class="col-md-6"><label class="form-label" for="barang_id">Laptop</label><select id="barang_id" name="barang_id" class="form-select" required><option value="">Pilih laptop</option>@foreach($barangs as $barang)<option value="{{ $barang->id }}" @selected(old('barang_id') == $barang->id)>{{ $barang->nama_barang }} · {{ $barang->kode_barang }} (tersedia {{ $barang->jumlah }})</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label" for="jumlah">Jumlah unit</label><input id="jumlah" type="number" name="jumlah" min="1" class="form-control" value="{{ old('jumlah', 1) }}" required></div>
    <div class="col-md-4"><label class="form-label" for="peminjaman_pada">Peminjaman pada</label><input id="peminjaman_pada" type="datetime-local" name="peminjaman_pada" class="form-control" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('peminjaman_pada', now()->format('Y-m-d\TH:i')) }}" required></div>
    <div class="col-md-4"><label class="form-label" for="waktu_kembali_rencana">Jam pengembalian</label><input id="waktu_kembali_rencana" type="time" name="waktu_kembali_rencana" class="form-control" value="{{ old('waktu_kembali_rencana') }}" required><small class="form-text">Hanya bisa dalam satu hari, bukan berhari-hari.</small></div>
    <div class="col-md-6"><label class="form-label" for="guru_produktif">Guru Produktif</label><select id="guru_produktif" name="guru_produktif" class="form-select" required><option value="">Pilih guru produktif</option>@foreach(config('peminjaman.guru_produktif') as $guru)<option value="{{ $guru }}" @selected(old('guru_produktif') === $guru)>{{ $guru }}</option>@endforeach</select></div>
    <div class="col-md-6"><label class="form-label" for="mata_pelajaran">Mata Pelajaran</label><select id="mata_pelajaran" name="mata_pelajaran" class="form-select" required><option value="">Pilih mata pelajaran</option>@foreach(config('peminjaman.mata_pelajaran') as $mataPelajaran)<option value="{{ $mataPelajaran }}" @selected(old('mata_pelajaran') === $mataPelajaran)>{{ $mataPelajaran }}</option>@endforeach</select></div>
    <div class="col-12"><label class="form-label" for="keperluan">Keperluan</label><textarea id="keperluan" name="keperluan" class="form-control" rows="3" maxlength="1000">{{ old('keperluan') }}</textarea></div>
</div>
<div class="d-flex gap-2 mt-4"><button class="btn btn-primary"><i class="bi bi-send me-1"></i>Simpan Pengajuan</button><a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a></div></div></form>
@endsection
