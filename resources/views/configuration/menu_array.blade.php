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
        ]
      ],
    ],
    [
      "name"=>"Roles",
      "icon"=>"fa fa-sitemap",
      "dropdown"=>true,
      "route"=>"",
      "dropdown_items"=>[
        [
          "name"=>"Add Role",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.roles.create"
        ],
        [
          "name"=>"Manage Roles",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.roles.index"
        ]
      ],
    ],
    [
      "name"=>"Geo Data",
      "icon"=>"fa fa-globe",
      "dropdown"=>true,
      "route"=>"",
      "dropdown_items"=>[
        [
          "name"=>"Manage Countries",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.countries.index"
        ],
        [
          "name"=>"Manage States",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.states.index"
        ],
        [
          "name"=>"Manage Cities",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.cities.index"
        ],
        [
          "name"=>"Manage Zipcodes",
          "icon"=>"fa fa-circle-o",
          "route"=>"admin.zipcodes.index"
        ]
      ],
    ]
    //Menu name => route (No Dropdown)
    // 'Logout'=> 'admin.logout'
  ];
?>