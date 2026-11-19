{{-- Menggunakan layout khusus halaman tamu, seperti login dan daftar. --}}
@extends('layouts.guest')
{{-- Mengatur judul halaman yang ditampilkan oleh layout. --}}
@section('title', 'Login')
{{-- Mengisi teks slogan pada bagian cerita di layout. --}}
@section('story-title', 'Laptop sekolah, dipinjam dengan lebih tertata.')
{{-- Memulai bagian utama yang akan mengisi halaman login. --}}
@section('content')
{{-- Judul sambutan pada halaman login. --}}
<h2 class="h3 fw-bold mb-2">Selamat datang</h2>
{{-- Petunjuk singkat agar pengguna masuk untuk mengelola peminjaman. --}}
<p class="text-secondary mb-4">Masuk untuk mengelola peminjaman laptop sekolah.</p>
{{-- Jika ada pesan sukses dari sistem, tampilkan sebagai pemberitahuan. --}}
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
{{-- Jika ada kesalahan, tampilkan pesan kesalahan pertama. --}}
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
{{-- Membuat formulir login yang mengirim data dengan metode POST ke proses login. --}}
<form action="{{ route('login.submit') }}" method="POST">
    {{-- Menambahkan token keamanan Laravel pada formulir. --}}
    @csrf
    {{-- Kolom untuk memasukkan alamat email. --}}
    <div class="mb-3"><label class="form-label fw-semibold" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="username" required autofocus></div>
    {{-- Kolom untuk memasukkan password dan tombol untuk menampilkannya. --}}
    <div class="mb-3"><label class="form-label fw-semibold" for="password">Password</label><div class="input-group"><input id="password" type="password" name="password" class="form-control" autocomplete="current-password" required><button class="btn btn-outline-secondary" type="button" data-toggle-password="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div></div>
    {{-- Pilihan untuk mengingat pengguna dan tautan jika lupa password. --}}
    <div class="d-flex justify-content-between align-items-center mb-4"><label class="form-check mb-0"><input type="checkbox" name="remember" class="form-check-input" id="remember"><span class="form-check-label">Ingat saya</span></label><a href="{{ route('password.request') }}" class="small fw-semibold">Lupa Password?</a></div>
    {{-- Tombol untuk mengirim email dan password ke proses login. --}}
    <button type="submit" class="btn btn-primary w-100">Login <i class="bi bi-arrow-right ms-1"></i></button>
</form>
{{-- Tautan menuju halaman pendaftaran akun. --}}
<p class="text-center text-secondary mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar</a></p>
{{-- Mengakhiri bagian isi halaman. --}}
@endsection
