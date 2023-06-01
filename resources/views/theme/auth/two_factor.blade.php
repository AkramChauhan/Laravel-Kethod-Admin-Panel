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
                      <div class="card-header">
                        <i class="fa fa-lg fa-fw fa-user"></i>{{ __('Two Factor Verification') }}
                      </div>
                      <div class="card-body">
                          <form method="POST" action="{{ route('verify.store') }}">
                              @csrf
                              <p class="text-muted">You have recieved an email which contain verification code.
                              If you haven't received it, Click <a href="{{ route('verify.resend') }}">here</a>
                              </p>
                              <div class="form-group">
                                <label for="two_factor_code" class="control-label">{{ __('Two Factor Code') }}</label>
                                <input id="two_factor_code" type="text" class="form-control @error('two_factor_code') is-invalid @enderror" name="two_factor_code" value="" required autofocus>

                                @error('two_factor_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>

                              <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                              </div>
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
