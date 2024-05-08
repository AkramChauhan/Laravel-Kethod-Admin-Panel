<!DOCTYPE html>
<html lang="en">

<head>
  @include('backend.layouts.partial.meta')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/main.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/plugins/font-awesome-4.7.0/font-awesome.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/custom.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/global.css') }}" />
  @stack('styles')
</head>

<body class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header">
    <?php
    $settings = getSettings();
    ?>
    <a class="app-header__logo" href="{{ route('admin.dashboard') }}">{{ $settings['SITE_NAME']['value'] }}</a>
    <!-- Sidebar toggle button-->
    @if(Auth::check())
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    @endif
    <!-- Navbar Right Menu-->
    <ul class="app-nav">

      <!-- User Menu-->
      <li class="dropdown">
        <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li>
            <a class="dropdown-item" href="{{ route('admin.settings.edit_profile') }}">
              <i class="fa fa-edit"></i> {{ __('Edit Profile') }}</a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out fa-lg"></i> {{ __('Logout') }}</a>
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
  include('../resources/views/configuration/menu_array.blade.php');
  ?>
  @include($theme_name.'.layouts.partial.menu_items')
  @endif
  <main class="app-content">
    @yield('content')
  </main>
  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('backend/assets/plugins/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('backend/assets/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('backend/assets/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/assets/plugins/pace.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>
  @stack('scripts')
</body>

</html>