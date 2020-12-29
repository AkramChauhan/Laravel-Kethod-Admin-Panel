<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <div>
      <p class="app-sidebar__user-name">Welcome</p>
      <p class="app-sidebar__user-designation">{{ Auth::user()->name }}</p>
    </div>
  </div>
  <ul class="app-menu">
    <?php
    foreach($menu as $menu_items){
      if($menu_items['dropdown']==false){ ?>
        <li>
          <a class="app-menu__item <?php if(Request::route()->getName()==$menu_items['route']){ echo "active"; } ?>" href="{{ route($menu_items['route']) }}">
            <i class="app-menu__icon {{ $menu_items['icon'] }}"></i>
            <span class="app-menu__label">{{ $menu_items['name'] }}</span>
          </a>
        </li>
        <?php
      }else{ ?>
        <li class="treeview <?php if(in_array(Request::route()->getName(),$menu_items['dropdown_items'])) { echo "is-expanded"; }?>">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon {{ $menu_items['icon'] }}"></i>
            <span class="app-menu__label"> {{ $menu_items['name'] }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php
              foreach($menu_items['dropdown_items'] as $sub_menu){
            ?>
            <li>
              <a
                class="treeview-item <?php if(Request::route()->getName()==$sub_menu['route']){ echo "active"; } ?>"
                href="{{ route($sub_menu['route']) }}"
                rel="noopener">
                <i class="icon {{ $sub_menu['icon'] }}"></i> {{ $sub_menu['name'] }}</a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php
      } 
    } ?> 
  </ul>
</aside>