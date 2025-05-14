@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="fw-bold fs-5">{{ $pagetitle }}</div>
                    <div class="text-subtitle text-muted">
                        {{ $information }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="my-3 d-flex align-items-center justify-content-end">
                        <div class="dropdown me-2" id="dropdown-aksi">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-cogs"></i> Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-import">
                                        Import
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route($route.'.export') }}" class="dropdown-item">
                                        Export
                                    </a>
                                </li>
                            </ul>
                        </div>

                        @if(GlobalHelper::isHaveAbility($permission.'create'))
                        <a href="{{ route($route.'.create') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        @endif
                    </div>

                    <div class="py-3">
                        @include('partials.admin.alert')

                        @error('file')
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <table class="table w-100" id="{{ $table }}"></table>
                </div>
            </div>
        </div>
    </div>                  
</div>

<div class="modal fade" id="modal-import" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Santri</h4>
                <button class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route($route.'.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="file">File</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light" href="{{ asset('examples/santri-import.xlsx') }}"><i class="fa fa-download"></i> Contoh File</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link href="{{ asset('/vendor/DataTables/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('/vendor/DataTables/datatables.min.js') }}" type="text/javascript"></script>

<script>
    $(function(){
        const id        = '#{{ $table }}';
        const url       = "{{ route($route.'.paginate') }}";
        const columns   = [
            {
                data: 'no',
                title: 'No.',
                width: 50,
                orderable: false
            },
            {
                data: 'nis',
                title: 'NIS'
            },
            {
                data: 'nama',
                title: 'Nama'
            },
            {
                data: 'alamat',
                title: 'Alamat'
            },
            {
                data: 'asrama_nama',
                title: 'Asrama'
            },
            {
                data: 'total_paket',
                title: 'Total Paket'
            },
            {
                data: 'action',
                title: 'Aksi',
                width: 250,
                orderable: false
            }
        ];

        initDatatable(id, url, columns);
    });
</script>
    
@endsection