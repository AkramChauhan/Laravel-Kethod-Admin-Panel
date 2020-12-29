<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              @foreach($menu as $menu_items)
              <?php
                if($menu_items['dropdown']==false){ ?>
                  <li class="nav-item <?php if(Request::route()->getName()==$menu_items['route']){ echo "active"; } ?>">
                    <a class="nav-link" href="{{ route($menu_items['route']) }}">{{ $menu_items['name'] }}</a>
                  </li>

                  <?php
                }else{
                  ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ $menu_items['name'] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <?php
                      foreach($menu_items['dropdown_items'] as $sub_menu){ ?>
                        <a class="dropdown-item" href="{{ route($sub_menu['route']) }}">{{ $sub_menu['name'] }}</a>
                      <?php } ?>
                    </div>
                  </li>
                  <?php
                }
              ?> 
              @endforeach
            </ul>
          </div>
        </div>
      </div>
  </div>
</nav>
