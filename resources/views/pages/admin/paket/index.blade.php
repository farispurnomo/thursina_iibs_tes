@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header border-bottom">
                    <div class="fw-bold fs-5">{{ $pagetitle }}</div>
                    <div class="text-subtitle text-muted">
                        {{ $information }}
                    </div>
                </div>
                <form id="form-filter" method="POST" action="{{ route($route.'.export') }}">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tgl_awal" class="form-label">Tanggal Terima</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="{{ date('Y-m-01') }}" required/>
                                <span class="input-group-text">s/d</span>
                                <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="{{ date('Y-m-d') }}" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="select2" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <div class="p-1">
                                <button class="btn btn-primary" type="button" id="btn-cari">
                                    <i class="fa fa-search"></i>
                                    <span>Cari</span>
                                </button>
                                <button class="btn btn-light" type="submit">
                                    <i class="fa fa-file-excel"></i>
                                    <span>Eksport</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <div class="fw-bold fs-5">{{ $pagetitle }}</div>
                    <div class="text-subtitle text-muted">
                        {{ $information }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="my-3 text-end">
                        @if(GlobalHelper::isHaveAbility($permission.'create'))
                        <a href="{{ route($route.'.create') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        @endif
                    </div>

                    <div class="py-3">
                        @include('partials.admin.alert')
                    </div>

                    <table class="table w-100" id="{{ $table }}"></table>
                </div>
            </div>
        </div>
    </div>                  
</div>
@endsection

@section('scripts')
<link href="{{ asset('/vendor/DataTables/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('/vendor/DataTables/datatables.min.js') }}" type="text/javascript"></script>

<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2-bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

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
                data: 'nama',
                title: 'Nama'
            },
            {
                data: 'tgl_diterima',
                title: 'Tanggal Terima'
            },
            {
                data: 'kategori_nama',
                title: 'Kategori'
            },
            {
                data: 'asrama_nama',
                title: 'Asrama'
            },
            {
                data: 'penerima_nama',
                title: 'Penerima'
            },
            {
                data: 'state',
                title: 'Status'
            },
            {
                data: 'action',
                title: 'Aksi',
                width: 250,
                orderable: false
            }
        ];

        let datatable;

        const renderTable = function(){
            if (datatable){
                datatable.ajax.reload();
            }else{
                datatable = initDatatable(id, url, columns, {
                    tgl_awal    : () => $('#tgl_awal').val(),
                    tgl_akhir   : () => $('#tgl_akhir').val(),
                    kategori_id : () => $('#kategori_id').val(),
                });
            }
        };

        renderTable();

        $('#btn-cari').on('click', function(e){
            e.preventDefault();
            
            renderTable();
        });

        const kategoriOptions = {
            route_to    : "{{ route('admin.settings.kategori_paket.options') }}",
            placeholder : 'Semua Kategori',
            allowClear  : true
        }
        initSelect2('#kategori_id', kategoriOptions);
    });
</script>
    
@endsection