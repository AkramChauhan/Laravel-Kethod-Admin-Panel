<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fa fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
              <div class="nav">
                  <div class="sb-sidenav-menu-heading">Navigation</div>
                  <?php
                  foreach($menu as $menu_items){
                    if($menu_items['dropdown']==false){ ?>
                      <a class="nav-link <?php if(Request::route()->getName()==$menu_items['route']){ echo "active"; } ?>" href="{{ route($menu_items['route']) }}">
                          <div class="sb-nav-link-icon"><i class="{{ $menu_items['icon'] }}"></i></div>
                          {{ $menu_items['name'] }}
                      </a>
                      <?php
                    }else{ 
                      // dd();
                      $cls_name='';
                      $active_cls = '';
                      $collapse_cls = 'collapsed';
                      if (is_array($menu_items['dropdown_items'])) {
                        foreach ($menu_items['dropdown_items'] as $key => $value) {
                          if(in_array(Request::route()->getName(),$value)){
                            $cls_name = "show";
                            $active_cls = 'active';
                            $collapse_cls = '';
                          }
                        }
                      }
                      // (in_array(,$menu_items['dropdown_items']))
                      ?>
                      <a class="nav-link {{ $collapse_cls }} {{ $active_cls }}" href="#" data-toggle="collapse" data-target="#collapseLayouts{{ $menu_items['name'] }}" aria-expanded="true" aria-controls="collapseLayouts{{ $menu_items['name'] }}">
                        <div class="sb-nav-link-icon"><i class="{{ $menu_items['icon'] }}"></i></div>
                        {{ $menu_items['name'] }}
                        <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                      </a>
                      <div class="collapse {{ $cls_name }}" id="collapseLayouts{{ $menu_items['name'] }}" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                          <nav class="sb-sidenav-menu-nested nav">
                            <?php
                              foreach($menu_items['dropdown_items'] as $sub_menu){
                            ?>
                              <a class="nav-link <?php if(Request::route()->getName()==$sub_menu['route']){ echo "active"; } ?>" href="{{ route($sub_menu['route']) }}">{{ $sub_menu['name'] }}</a>
                            <?php 
                              }
                            ?>
                          </nav>
                      </div>
                      <?php
                    } 
                  } ?>
              </div>
          </div>
          <div class="sb-sidenav-footer">
              <div class="small">Logged in as:</div>
              {{ Auth::user()->name }}
          </div>
      </nav>
  </div>