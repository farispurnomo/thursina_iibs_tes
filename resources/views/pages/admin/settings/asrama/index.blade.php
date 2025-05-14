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
                data: 'gedung',
                title: 'Gedung'
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