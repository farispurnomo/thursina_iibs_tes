@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <form action="{{ route($route.'.update', $record->id) }}" method="POST">
                @csrf
                @method('PUT')
    
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
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $record->nama }}" required>
                                    @error('nama')
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>
    
            </form>
        </div>
    </div>
</div>
@endsection