<aside class="app-sidebar">
    @php
    $user = Auth::user();
    $currentRole = Request::route()->parameter('role');
    $currentRoute = Request::route()->getName(); // Adjust this based on how you store the user's role
    @endphp

    @if(Auth::check())
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">Welcome</p>
            <p class="app-sidebar__user-designation">{{ $user->name }}</p>
        </div>
    </div>
    @endif

    <ul class="app-menu">
        @foreach ($menu as $key => $menu_item)
        @php
        $link_active = "";
        $menuRoute = $menu_item['route'] ?? null;
        $menuRole = $menu_item['role'] ?? null;
        $menuDropdown = $menu_item['dropdown'] ?? false;
        $menuDropdownItems = $menu_item['dropdown_items'] ?? [];

        if (
        ((!isset($menuRole) && $currentRoute == $menuRoute) ||
        (isset($menuRole) && $currentRole == $menuRole))
        ) {
        $link_active = "active";
        }

        $params = isset($menuRole) ? ['role' => $menuRole] : [];
        @endphp

        @if($user->is_user && $key === 1)
        @continue
        @endif

        @if (!$menuDropdown && (!$menuRole || $currentRole == $menuRole))
        <li>
            <a class="app-menu__item {{ $link_active }}" href="{{ route($menuRoute, $params) }}">
                <i class="app-menu__icon {{ $menu_item['icon'] }}"></i>
                <span class="app-menu__label">{{ $menu_item['name'] }}</span>
            </a>
        </li>
        @elseif ($menuDropdown && (!$menuRole || $currentRole == $menuRole))
        @php
        $expanded = '';

        foreach ($menuDropdownItems as $submenu) {
        if (
        (isset($menuRole) && $currentRole == $menuRole) ||
        (!isset($menuRole) && in_array($currentRoute, $submenu))
        ) {
        $expanded = "is-expanded";
        break;
        }
        }
        @endphp

        <li class="treeview {{ $expanded }}">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon {{ $menu_item['icon'] }}"></i>
                <span class="app-menu__label"> {{ $menu_item['name'] }}</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach ($menuDropdownItems as $sub_menu)
                @php
                $subMenuRoute = $sub_menu['route'];
                @endphp

                <li>
                    <a class="treeview-item {{ (($currentRoute == $subMenuRoute && !isset($menuRole)) || (isset($menuRole) && $currentRole == $menuRole && $currentRoute == $subMenuRoute)) ? 'active' : '' }}" href="{{ route($subMenuRoute, $params) }}" rel="noopener">
                        <i class="icon {{ $sub_menu['icon'] }}"></i> {{ $sub_menu['name'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
    </ul>
</aside>