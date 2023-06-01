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
    <meta property="og:site_name" content="Admin" />
    <meta property="og:title" content="Kethod panel" />
    <meta property="og:url" content="http:/localhost:8000" />
    <meta property="og:description" content=""/><title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/main.css') }}" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome-4.7.0/font-awesome.min.css') }}"/>
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
    <script src="{{ asset('theme/plugins/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('theme/plugins/pace.min.js') }}"></script>
    @stack('scripts')
  </body>
</html>
