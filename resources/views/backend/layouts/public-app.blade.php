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

<body class="app">
  @yield('content')
  <!-- Essential javascripts for application to work-->
  @stack('scripts')
  <script src="{{ asset('backend/assets/plugins/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
</body>

</html>