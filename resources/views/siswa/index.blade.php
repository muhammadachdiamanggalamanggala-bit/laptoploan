@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Siswa</h4>

    <a href="{{ route('siswa.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Siswa
    </a>
</div>

<div class="card card-shadow">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($siswa as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->nama_siswa }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->jurusan }}</td>
                            <td>
                                <a href="{{ route('siswa.edit', $item->id) }}"
                                   class="btn btn-sm btn-success">
                                    Edit
                                </a>

                                <form action="{{ route('siswa.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection