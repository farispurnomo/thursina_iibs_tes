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

        <hr/>

        <div class="text-center fw-bold">
            Lupa Kata Sandi
        </div>

        <form class="mb-3" action="{{ route($route.'.email') }}" method="post" autocomplete="off">
            @csrf

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check"></i> {{ session('status') }}
                </div>
            @endif
        
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
                <button class="btn btn-primary d-grid w-100" type="submit">Konfirmasi</button>
            </div>
            <p class="text-center">
                <span>Login?</span>
                <a class="text-decoration-none" href="{{ route('auth.login') }}">Klik Disini</a>
            </p>
        </form>
    </div>
</div>
@endsection