@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <form action="{{ route($route.'.store_privilege', $role->id) }}" method="POST">
                @csrf
    
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="fw-bold fs-5">{{ $pagetitle }} {{ $role->name }}</div>
                        <div class="text-subtitle text-muted">
                            {{ $information }}
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @include('partials.admin.alert')

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Privilege</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('pages.admin.users.role.privilege_item', ['menus' => $menus, 'privileges' => $privileges, 'deep' => 0])
                                </tbody>
                            </table>
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
<script>
    $(function(){
        $(document).on('change', '[name="privileges[]"]', function(){
            const name = $(this).data('name');

            const ability = name.split(':');
            if(ability.length < 2) return;

            const is_checked = $(this).is(':checked');

            const menu = ability[0];
            const ability_name = ability[1];

            if(ability_name != 'read'){
                const read_ability = $('form').find('input[data-name="' + menu + ':read"]')
                if(is_checked){
                    read_ability.prop('checked', true);
                    read_ability.prop('readonly', true);
                }else{
                    read_ability.prop('readonly', false);
                }
            }else{
                const another_ability = $('form').find('input[data-name^="' + menu + '"]:not(input[data-name="'+name+'"])');
                let counter = 0;
                another_ability.each((i, element) => {
                    if($(element).is(':checked')){
                        counter++;
                    }
                });

                if(counter > 0){
                    $(this).prop('checked', true)
                        .prop('readonly', true)
                }
            }
        });

        $(document).on('click', ':checkbox[readonly]', function(){
            return false;
        })
    });
</script>
@endsection