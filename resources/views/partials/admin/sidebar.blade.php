<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a href="" class="app-brand-link text-dark">
            <span class="app-brand-logo me-2">
                <img draggable="false" src="{{ asset('/images/logo_short.png') }}" alt="Logo" width="48"/>
            </span>
            <span class="fw-bold">{{ config('app.name') }}</span>
        </a>
        
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach(GlobalHelper::getMenuUserLogin() as $menu)
            @if(empty($menu['childs']))
                <li class="menu-item {{ (strpos(url()->current(), $menu['url']) !== FALSE ? 'active' : '') }}">
                    <a href="{{ URL::to($menu['url']) }}" class="menu-link">
                        <i class="menu-icon tf-icons {{ $menu['icon'] }}"></i>
                        <span>
                            <span class="me-1">{{ $menu['title'] }}</span>

                            @if($menu['notif']['enabled'])
                                @if($menu['notif']['value'] > 0)
                                    <span class="badge bg-danger">{{ $menu['notif']['value'] }}</span>
                                @endif
                            @endif
                        </span>
                    </a>
                </li>
            @else
                <li class="menu-item {{ (strpos(url()->current(), $menu['url']) !== FALSE ? 'active open' : '') }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons {{ $menu['icon'] }}"></i>
                        <span>
                            <span class="me-1">{{ $menu['title'] }}</span>

                            @if($menu['notif']['enabled'])
                                @if($menu['notif']['value'] > 0)
                                    <span class="badge bg-danger">{{ $menu['notif']['value'] }}</span>
                                @endif
                            @endif
                        </span>
                    </a>
                    @include('partials.admin.subsidebar', ['childs' => $menu['childs']])
                </li>
            @endif
        @endforeach
    </ul>
</aside>
