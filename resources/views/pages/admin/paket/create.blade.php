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
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="kategori_id">Kategori</label>
                                    <select name="kategori_id" id="kategori_id" class="select2" style="width: 100%" required></select>
                                    @error('kategori_id')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tgl_diterima">Tanggal Diterima</label>
                                    <input type="date" class="form-control @error('tgl_diterima') is-invalid @enderror" id="tgl_diterima" name="tgl_diterima" value="{{ old('tgl_diterima', date('Y-m-d')) }}" required>
                                    @error('tgl_diterima')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="isi_yg_disita">Isi Paket Yang Disita</label>
                                    <input type="text" class="form-control @error('isi_yg_disita') is-invalid @enderror" id="isi_yg_disita" name="isi_yg_disita" value="{{ old('isi_yg_disita') }}">
                                    @error('isi_yg_disita')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="asrama_id">Asrama</label>
                                    <select name="asrama_id" id="asrama_id" class="select2" style="width: 100%" required></select>
                                    @error('asrama_id')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="penerima_id">Penerima</label>
                                    <select name="penerima_id" id="penerima_id" class="select2" style="width: 100%" required></select>
                                    @error('penerima_id')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="pengirim">Pengirim</label>
                                    <input type="text" class="form-control @error('pengirim') is-invalid @enderror" id="pengirim" name="pengirim" value="{{ old('pengirim') }}" required>
                                    @error('pengirim')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="belum" id="statusBelum" checked>
                                        <label class="form-check-label" for="statusBelum">
                                            Belum Diambil
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="diambil" id="statusDiambil">
                                        <label class="form-check-label" for="statusDiambil">
                                            Sudah Diambil
                                        </label>
                                    </div>
                                    @error('status')
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

@section('scripts')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2-bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

<script>
    $(function(){
        const kategoriOptions = {
            route_to    : "{{ route('admin.settings.kategori_paket.options') }}",
            placeholder : 'Pilih Kategori',
            allowClear  : false
        }
        initSelect2('#kategori_id', kategoriOptions);

        const asramaOptions = {
            route_to    : "{{ route('admin.settings.asrama.options') }}",
            placeholder : 'Pilih Asrama',
            allowClear  : false
        }
        initSelect2('#asrama_id', asramaOptions);

        const santriOptions = {
            route_to    : undefined,
            placeholder : 'Pilih Penerima',
            allowClear  : false
        };
        initSelect2('#penerima_id', santriOptions);

        $('#asrama_id').on('change', function(){
            const santriOptions = {
                route_to    : "{{ route('admin.settings.santri.options') }}?asrama_id=" + this.value,
                placeholder : 'Pilih Santri',
                allowClear  : false
            };
            initSelect2('#penerima_id', santriOptions);
        });
    });
</script>
@endsection