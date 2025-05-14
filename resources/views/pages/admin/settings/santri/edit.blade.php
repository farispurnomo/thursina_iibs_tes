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
                                    <label class="form-label" for="nis">NIS</label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ $record->nis }}" disabled>
                                    @error('nis')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
                                <div class="mb-3">
                                    <label class="form-label" for="asrama_id">Asrama</label>
                                    <select name="asrama_id" id="asrama_id" class="select2" style="width: 100%">
                                        @if($record->asrama)
                                        <option value="{{ $record->asrama_id }}">{{ $record->asrama->nama }}</option>
                                        @endif
                                    </select>
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ $record->alamat }}</textarea>
                                    @error('alamat')
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

@section('scripts')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2-bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

<script>
    $(function(){
        const asramaOptions = {
            route_to    : "{{ route('admin.settings.asrama.options') }}",
            placeholder : 'Pilih Asrama',
            allowClear  : false
        }
        initSelect2('#asrama_id', asramaOptions);
    });
</script>
@endsection