@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <form action="{{ route($route.'.store') }}" method="POST">
                @csrf
    
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="fw-bold fs-5">{{ $pagetitle }}</div>
                        <div class="text-subtitle text-muted">
                            {{ $information }}
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @include('partials.admin.alert')
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan Nama" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
        
                                <div class="mb-3">
                                    <label class="form-label" for="description">Deskripsi</label>
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Masukkan Deskripsi" name="description" value="{{ old('description') }}">
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-light" href="{{ route($route.'.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
    
            </form>
        </div>
    </div>
</div>
@endsection