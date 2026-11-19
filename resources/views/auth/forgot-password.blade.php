@extends('layouts.guest')
@section('title', 'Lupa Password')
@section('story-title', 'Akses akun bisa dipulihkan dengan aman.')
@section('content')
<h2 class="h3 fw-bold mb-2">Lupa Password?</h2>
<p class="text-secondary mb-4">Masukkan email akun. Kami akan mengirim tautan reset password jika layanan email sudah dikonfigurasi.</p>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-4"><label class="form-label fw-semibold" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required autofocus></div>
    <button class="btn btn-primary w-100" type="submit">Kirim tautan reset</button>
</form>
<p class="text-center mt-4 mb-0"><a href="{{ route('login') }}" class="fw-semibold"><i class="bi bi-arrow-left me-1"></i>Kembali ke Login</a></p>
@endsection
