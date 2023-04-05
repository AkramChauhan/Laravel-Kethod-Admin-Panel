<?php
  // Menu structure support dropdown too.

  $menu = [
    //Menu without dropdown
    [
      "name"=>"Dashboard",
      "icon"=>"fa fa-dashboard",
      "dropdown"=>false,
      "route"=>"admin.dashboard",
      "dropdown_items"=>[],
    ],
    //Menu with dropdown
    [
      "name"=>"Users",
      "icon"=>"fa fa-users",
      "dropdown"=>true,
      "route"=>"",
      "dropdown_items"=>[
        [
          "name"=>"Add User",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.users.create"
        ],
        [
          "name"=>"Manage Users",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.users.index"
        ],
        [
          "name"=>"Manage User Roles",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.roles.index"
        ]
      ],
    ],
    [
      "name"=>"Pages",
      "icon"=>"fa fa-file",
      "dropdown"=>true,
      "route"=>"",
      "dropdown_items"=>[
        [
          "name"=>"Add Page",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.pages.create"
        ],
        [
          "name"=>"Manage Pages",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.pages.index"
        ],
      ],
    ],
    [
      "name"=>"Settings",
      "icon"=>"fa fa-gear",
      "dropdown"=>true,
      "route"=>"",
      "dropdown_items"=>[
        [
          "name"=>"General Settings",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.settings.index"
        ],
        [
          "name"=>"Edit Profile",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.settings.edit_profile"
        ]
      ],
    ]
    //Menu name => route (No Dropdown)
    // 'Logout'=> 'admin.logout'
  ];
?>