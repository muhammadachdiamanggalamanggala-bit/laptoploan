@extends('layouts.guest')
@section('title', 'Daftar Akun')
@section('story-title', 'Mulai pinjam laptop dengan akunmu.')
@section('content')
<h2 class="h3 fw-bold mb-2">Daftar Akun</h2>
<p class="text-secondary mb-4">Buat akun peminjam untuk mengajukan dan memantau peminjaman.</p>
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('register.submit') }}">
    @csrf
    <div class="mb-3"><label class="form-label fw-semibold" for="name">Nama</label><input id="name" name="name" class="form-control" value="{{ old('name') }}" autocomplete="name" required autofocus></div>
    <div class="mb-3"><label class="form-label fw-semibold" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required></div>
    <div class="mb-3"><label class="form-label fw-semibold" for="password">Password</label><div class="input-group"><input id="password" type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required><button class="btn btn-outline-secondary" type="button" data-toggle-password="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div><div class="form-text">Minimal 8 karakter.</div></div>
    <div class="mb-4"><label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required></div>
    <button class="btn btn-primary w-100" type="submit">Buat akun <i class="bi bi-arrow-right ms-1"></i></button>
</form>
<p class="text-center text-secondary mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk</a></p>
@endsection

