<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="{{ asset('themes/sb-admin/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('themes/sb-admin/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
        @stack('styles')
        <link href="{{ asset('themes/sb-admin/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/sb-admin/css/primary_colors.css') }}" rel="stylesheet">
    </head>
    <?php
      $bg_class = 'sb-nav-fixed';
      $is_auth_page = false;
      $layout_cls = "layoutSidenav_content";
      if(Request::route()->getName()=='login' || Request::route()->getName()=='register' || Request::route()->getName()=='password.request'){
        $is_auth_page = true;
        $bg_class = 'bg-primary';
        $layout_cls = 'layoutAuthentication_content';
      }
    ?>
    <body class="{{ $bg_class }}">
        @if(Auth::check())
            <?php
                include('../resources/views/configuration/menu_array.blade.php');
            ?>
            @include('themes.sb-admin.layouts.partial.menu_items')
        @endif
        @if($is_auth_page)
        <div id="layoutAuthentication">
        @endif
            <div id="{{ $layout_cls }}">
                <main>
                    @yield('content')
                </main>
            @if($is_auth_page)
            </div>
            <div id="layoutAuthentication_footer">
            @endif
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            @if($is_auth_page)
                </div>
            @endif
        </div>
        @if(Auth::check()) 
        </div>
        @endif   
        <script src="{{ asset('themes/sb-admin/js/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('themes/sb-admin/js/scripts.js') }}"></script>
        @stack('scripts')
    </body>
</html>
