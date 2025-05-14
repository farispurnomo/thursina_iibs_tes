@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <form action="{{ route($route.'.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{ $record->email }}" disabled>
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password" name="password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="customFile">Image <em class="small text-danger">Max. 2 MB</em></label>
    
                                    <div>
                                        <img draggable="false" src="{{ $record->url_image }}" id="logo" class="img-fluid img-thumbnail my-2" width="125" height="125">
                                    </div>
    
                                    <input type="file" id="customFile" class="form-control" accept=".jpeg,.png,.jpg" name="image">
                                    
                                    @error('image')
                                    <div class="invalid-feedback d-block">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
    
                                <div class="mb-3">
                                    <label class="form-label" for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" name="name" required value="{{ $record->name }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Phone" name="phone" value="{{ $record->phone }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="address">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Enter Address" name="address" value="{{ $record->address }}">
                                    @error('address')
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>
    
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function(){
        $('#customFile').on('change', function(e) {
            const file = e.target.files[0];
            const image = URL.createObjectURL(file);
            $('#logo').attr('src', image);
        })
    });
</script>
@endsection