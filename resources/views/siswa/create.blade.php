@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')

<h4 class="mb-3">Tambah Siswa</h4>

<div class="card card-shadow">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" value="{{ old('nama_siswa') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII RPL 1"
                    value="{{ old('kelas') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" placeholder="Contoh: RPL (opsional)"
                    value="{{ old('jurusan') }}">
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </form>

    </div>
</div>

@endsection