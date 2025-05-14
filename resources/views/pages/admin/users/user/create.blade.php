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
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password" name="password" required>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="role">Role</label>
                                    <select name="role_id" id="role" required class="select2" style="width: 100%">
                                        @if ($role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    </select>
                                    @error('role_id')
                                    <div class="invalid-feedback d-block">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="customFile">Image <em class="small text-danger">Max. 2 MB</em></label>
    
                                    <div>
                                        <img draggable="false" src="{{ asset('images/no_image.png') }}" id="logo" class="img-fluid img-thumbnail my-2" width="125" height="125">
                                    </div>
    
                                    <input type="file" id="customFile" class="form-control @error('image') is-invalid @enderror" accept=".jpeg,.png,.jpg" name="image">
                                    
                                    @error('image')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
    
                                <div class="mb-3">
                                    <label class="form-label" for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan Nama" name="name" required value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Masukkan Telepon" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label" for="address">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Masukkan Alamat" name="address" value="{{ old('address') }}">
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
        const roleOptions = {
            route_to    : "{{ route('admin.users.role.all') }}",
            placeholder : 'Pilih Role',
            allowClear  : false
        }
        initSelect2('#role', roleOptions);

        $('#customFile').on('change', function(e) {
            const file = e.target.files[0];
            const image = URL.createObjectURL(file);
            $('#logo').attr('src', image);
        })
    });
</script>
@endsection