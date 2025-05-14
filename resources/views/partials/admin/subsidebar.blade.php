<ul class="menu-sub {{ (strpos(url()->current(), $menu['url']) !== FALSE ? '' : '') }}">
    @foreach ($childs as $menu)
        @if(empty($menu['childs']))
            <li class="menu-item {{ (strpos(url()->current(), $menu['url']) !== FALSE ? 'active' : '') }}">
                <a href="{{ URL::to($menu['url']) }}" class="menu-link">
                    <span class="me-1">{{ $menu['title'] }}</span>
                    
                    @if($menu['notif']['enabled'])
                        @if($menu['notif']['value'] > 0)
                            <span class="badge bg-danger">{{ $menu['notif']['value'] }}</span>
                        @endif
                    @endif
                </a>
            </li>
        @else
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link">
                    <span class="me-1">{{ $menu['title'] }}</span>

                    @if($menu['notif']['enabled'])
                        @if($menu['notif']['value'] > 0)
                            <span class="badge bg-danger">{{ $menu['notif']['value'] }}</span>
                        @endif
                    @endif
                </a>
                @include('partials.admin.subsidebar', ['childs' => $menu['childs']])
            </li>
        @endif
    @endforeach
</ul>