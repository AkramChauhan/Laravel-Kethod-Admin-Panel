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
    @stack('styles')
  </head>
  <body class="app sidebar-mini rtl">
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>{{ config('app.name', 'Laravel') }}</h1>
      </div>

      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-6">
                  <div class="card">
                      <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                      <div class="card-body">
                          @if (session('resent'))
                              <div class="alert alert-success" role="alert">
                                  {{ __('A fresh verification link has been sent to your email address.') }}
                              </div>
                          @endif

                          {{ __('Before proceeding, please check your email for a verification link.') }}
                          {{ __('If you did not receive the email') }},
                          <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                              @csrf
                              <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>

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
