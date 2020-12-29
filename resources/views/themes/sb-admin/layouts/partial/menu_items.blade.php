<?php
  // Menu structure support dropdown too.
  // If you provde array as value in any of the element, It will become dropdown.
  $menu = [
    //Main menu name
    "Dashboard"=>'admin.dashboard',
    'Users' =>  [
      //first item => route
      'Add User'=>'admin.users.create',
      'Manage Users'=>'admin.users.index',
    ],
    'Roles' =>  [
      //first item => route
      'Add Role'=>'admin.roles.create',
      'Manage Roles'=>'admin.roles.index',
    ],
    //Menu name => route (No Dropdown)
    // 'Logout'=> 'admin.logout'
  ];
  // print_r($menu);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            @foreach($menu as $menu_name=>$menu_item)
              <?php
                if(!is_array($menu_item)){
                  ?>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route($menu_item) }}">{{ $menu_name }}</a>
                  </li>
                  
                  <?php
                }else{
                  ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ $menu_name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <?php
                      foreach($menu_item as $sub_menu_name => $sub_menu_route){
                      ?>
                      <a class="dropdown-item" href="{{ route($sub_menu_route) }}">{{ $sub_menu_name }}</a>
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
