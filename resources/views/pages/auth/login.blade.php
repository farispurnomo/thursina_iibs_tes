@extends('layouts.auth.auth')

@section('content')
<style>
    .container {
        margin-top: auto !important;
        margin-bottom: auto !important;
    }
</style>
<div class="card mx-auto animate__animated animate__fadeIn bg-white my-5" style="max-width: 400px">
    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <img draggable="false" src="{{ asset('images/logo_long.png') }}" alt="" height="92">
        </div>
        
        <div class="text-center mb-3">
            <div class="fs-4 text-black fw-bold">{{ config('app.name') }}</div>
            <div class="small">Implementasi Praktek Web Aplikasi v2 2025</div>
        </div>
        
        <form class="mb-3" action="{{ route('auth.authenticate') }}" method="post" autocomplete="off">
            @csrf
        
            @include('partials.admin.alert')
        
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" autofocus>
                @error('email')
                <div class="invalid-feedback">
                    <i class="fa fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                <div class="invalid-feedback">
                    <i class="fa fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
                @enderror
            </div>
        
            <div class="mb-3">
                <div class="mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberMe">
                    <label class="form-check-label text-dark" for="rememberMe">Remember me</label>
                </div>
            </div>
        
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
            </div>
            <p class="text-center">
                <span>Lupa Kata Sandi?</span>
                <a class="text-decoration-none" href="{{ route('auth.password.request') }}">Klik Disini</a>
            </p>
        </form>
    </div>
</div>
@endsection