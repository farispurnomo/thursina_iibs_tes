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
                <form id="form-filter">
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
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_sita" value="1" id="is_sita">
                                <label class="form-check-label" for="is_sita">
                                    Paket Yang Disita
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <div class="p-1">
                                <button class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="fw-bold fs-5"><i class="fa fa-table"></i> Hasil Pencarian</div>
                </div>
                <div class="card-body">
                    <div class="py-3">
                        @include('partials.admin.alert')
                    </div>

                    <table class="table w-100" id="{{ $table }}"></table>
                </div>
            </div>
        </div>
    </div>                  
</div>
<form id="form-export" target="_blank" method="POST" class="d-none"></form>
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
                data: 'isi_yg_disita',
                title: 'Isi Paket Yang Disita'
            },
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
                    is_sita     : () => $('#is_sita').is(':checked') ? 1 : 0,
                });
            }
        };

        renderTable();

        $('#form-filter').on('submit', function(e){
            e.preventDefault();
            
            renderTable();
        });

        const kategoriOptions = {
            route_to    : "{{ route('admin.settings.kategori_paket.options') }}",
            placeholder : 'Semua Kategori',
            allowClear  : false
        }
        initSelect2('#kategori_id', kategoriOptions);
    });
</script>
    
@endsection