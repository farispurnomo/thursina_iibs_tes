@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <form action="{{ route($route.'.store') }}" method="POST">
                @csrf
    
                <div class="card">
                    <div class="card-header border-bottom row align-items-center">
                        <div class="col-md-8">
                            <div class="fw-bold fs-5">
                                <a href="{{ route($route. '.index') }}" class="text-body">
                                    <i class="fa fa-arrow-left"></i>
                                    {{ $pagetitle }}
                                </a>
                            </div>
                            <div class="text-subtitle text-muted mb-2">
                                {{ $information }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row justify-content-md-end">
                                <div class="col-auto order-2 order-md-1">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route($route. '.cetak', $record->id) }}"><i class="fa fa-print"></i> Cetak</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @include('partials.admin.alert')
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-label">NIS</div>
                                    <div>{{ $record->nis ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Nama</div>
                                    <div>{{ $record->nama ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Asrama</div>
                                    <div>{{ $record->asrama->nama ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Alamat</div>
                                    <div>{{ $record->alamat ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
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
            allowClear  : true
        }
        initSelect2('#asrama_id', asramaOptions);
    });
</script>
@endsection