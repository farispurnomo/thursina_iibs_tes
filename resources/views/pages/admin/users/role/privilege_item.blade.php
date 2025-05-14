@php $deep++ @endphp
@foreach ($menus as $menu)
    <tr>
        <td>
            <div style="padding-left: {{ $deep * 30 }}px">
                {{ $menu->title }}
            </div>
        </td>
        <td>
            @foreach($menu->abilities as $ability)
            <div class="form-check">
                <input type="checkbox" name="privileges[]" value="{{ $ability->id }}" class="form-check-input" data-name="{{ $ability->name }}" id="checkbox-{{ $ability->id }}" {{ in_array($ability->id, $privileges) ? 'checked' : '' }}>
                <label class="form-check-label" for="checkbox-{{ $ability->id }}">{{ $ability->name }}</label>
            </div>
            @endforeach
        </td>
    </tr>

    @if($menu->allChilds->isNotEmpty())
        @include('pages.admin.users.role.privilege_item', ['menus' => $menu->allChilds, 'privileges' => $privileges, 'deep' => $deep])
    @endif
@endforeach