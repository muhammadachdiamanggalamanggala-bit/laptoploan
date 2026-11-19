@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')

<h4 class="mb-3">Edit Siswa</h4>

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

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control"
                    value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $siswa->jurusan) }}">
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </form>

    </div>
</div>

@endsection