<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <div>
      <p class="app-sidebar__user-name">Welcome</p>
      <p class="app-sidebar__user-designation">{{ Auth::user()->name }}</p>
    </div>
  </div>
  <ul class="app-menu">
    <?php
    $currentRole = Request::route()->parameter('role');
    $currentRoute = Request::route()->getName();
    
    foreach($menu as $menu_items) {
      $link_active = "";
      
      $menuRoute = $menu_items['route'] ?? null;
      $menuRouteList = $menu_items['route_list'] ?? [];
      $menuRole = $menu_items['role'] ?? null;
      $menuDropdown = $menu_items['dropdown'] ?? false;
      $menuDropdownItems = $menu_items['dropdown_items'] ?? [];
      
      if (
        ((!isset($menuRole) && $currentRoute == $menuRoute) ||
        (isset($menuRouteList) && in_array($currentRoute, $menuRouteList))) ||
        (isset($menuRole) && $currentRole == $menuRole)
      ) {
        $link_active = "active";
      }
      
      $params = isset($menuRole) ? ['role' => $menuRole] : [];
      
      if (!$menuDropdown) { ?>
        <li>
          <a class="app-menu__item {{ $link_active }}" href="{{ route($menuRoute, $params) }}">
            <i class="app-menu__icon {{ $menu_items['icon'] }}"></i>
            <span class="app-menu__label">{{ $menu_items['name'] }}</span>
          </a>
        </li>
      <?php } else { 
        $expanded = '';
        
        foreach ($menuDropdownItems as $tmpt) {
          if (
            (isset($menuRole) && $currentRole == $menuRole) ||
            (!isset($menuRole) && in_array($currentRoute, $tmpt))
          ) {
            $expanded = "is-expanded";
            break;
          }
        }
      ?>
        <li class="treeview {{ $expanded }}">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon {{ $menu_items['icon'] }}"></i>
            <span class="app-menu__label"> {{ $menu_items['name'] }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php
            foreach ($menuDropdownItems as $sub_menu) {
              $subMenuRoute = $sub_menu['route'];
            ?>
              <li>
                <a class="treeview-item <?php echo (($currentRoute == $subMenuRoute && !isset($menuRole)) || (isset($menuRole) && $currentRole == $menuRole && $currentRoute == $subMenuRoute)) ? 'active' : ''; ?>" href="{{ route($subMenuRoute, $params) }}" rel="noopener">
                  <i class="icon {{ $sub_menu['icon'] }}"></i> {{ $sub_menu['name'] }}
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } 
    } ?> 
  </ul>
</aside>
