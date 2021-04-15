<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content=""/>
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:site" content="@pratikborsadiya" />
    <meta property="twitter:creator" content="@pratikborsadiya" />
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Vali Admin" />
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme" />
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin" />
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular."/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vali-bootstrap/css/main.css') }}" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vali-bootstrap/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vali-bootstrap/css/custom.css') }}" />
    @stack('styles')
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
      <a class="app-header__logo" href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
         <!-- Sidebar toggle button-->
         @if(Auth::check())
         <a
          class="app-sidebar__toggle"
          href="#"
          data-toggle="sidebar"
          aria-label="Hide Sidebar"
        ></a>
        @endif
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        
        <!-- User Menu-->
        <li class="dropdown">
          <a
            class="app-nav__item"
            href="#"
            data-toggle="dropdown"
            aria-label="Open Profile Menu"
            ><i class="fa fa-user fa-lg"></i
          ></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="{{ route('admin.settings.edit_profile') }}">
              <i class="fa fa-edit"></i>  {{ __('Edit Profile') }}</a>
              <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
              >
              <i class="fa fa-sign-out fa-lg"></i>  {{ __('Logout') }}</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    @if(Auth::check())
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <?php
          include ('../resources/views/configuration/menu_array.blade.php');
        ?>
        @include('themes.vali-bootstrap.layouts.partial.menu_items')
    @endif
    <main class="app-content">
      @yield('content')
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('themes/vali-bootstrap/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('themes/vali-bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('themes/vali-bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('themes/vali-bootstrap/js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('themes/vali-bootstrap/js/plugins/pace.min.js') }}"></script>
    @stack('scripts')
  </body>
</html>
