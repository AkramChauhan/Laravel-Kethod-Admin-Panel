<!DOCTYPE html>
<html lang="en">

<head>
  @include('backend.layouts.partial.meta')
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/plugins/bootstrap-5.3.3/css/bootstrap.min.css') }}" />
  <!-- Backend CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/backend.css') }}" />
  <!-- Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/custom.css') }}" />
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/plugins/font-awesome-6.5.2/css/all.min.css') }}" />
  @stack('styles')
</head>

<body class="app m-0 p-0" >
  <!-- Navbar-->
  <?php
  $settings = getSettings();
  ?>
  @if(Auth::check())
  <?php
  include('../resources/views/configuration/menu_array.blade.php');
  ?>
  @include($theme_name.'.layouts.partial.menu_items')
  @endif
  <main class="app-content p-5">
    @yield('content')
  </main>
  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('backend/assets/plugins/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('backend/assets/plugins/popper.min.js') }}" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="{{ asset('backend/assets/plugins/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
  @stack('scripts')
</body>

</html>