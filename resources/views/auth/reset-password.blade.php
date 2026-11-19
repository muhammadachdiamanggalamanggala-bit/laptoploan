@extends('layouts.guest')
@section('title', 'Atur Password Baru')
@section('story-title', 'Buat password baru untuk akunmu.')
@section('content')
<h2 class="h3 fw-bold mb-2">Atur Password Baru</h2>
<p class="text-secondary mb-4">Gunakan password yang kuat dan belum pernah dipakai.</p>
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3"><label class="form-label fw-semibold" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email', $email) }}" autocomplete="email" required></div>
    <div class="mb-3"><label class="form-label fw-semibold" for="password">Password baru</label><div class="input-group"><input id="password" type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required><button class="btn btn-outline-secondary" type="button" data-toggle-password="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div></div>
    <div class="mb-4"><label class="form-label fw-semibold" for="password_confirmation">Konfirmasi password</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required></div>
    <button class="btn btn-primary w-100" type="submit">Simpan password</button>
</form>
@endsection

