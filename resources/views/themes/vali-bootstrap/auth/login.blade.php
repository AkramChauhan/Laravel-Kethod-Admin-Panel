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
                    <div class="card-header">
                      <i class="fa fa-lg fa-fw fa-user"></i>{{ __('Login') }}
                    </div>
                    <div class="card-body">
                      <form class="login-form" method="POST" action="{{ route('login') }}"> 
                        @csrf
                        <div class="form-group">
                          <label class="control-label">Email</label>
                          <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label class="control-label">PASSWORD</label>
                          <input  id="password"class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <div class="utility">
                            <div class="animated-checkbox">
                              <label for="remember">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="label-text">{{ __('Remember Me') }}</span>
                              </label>
                            </div>
                            @if (Route::has('password.request'))
                            <p class="semibold-text mb-2"><a href="{{ route('password.request') }}" data-toggle="flip">{{ __('Forgot Your Password?') }}</a></p>
                            @endif
                          </div>
                        </div>
                        <div class="form-group btn-container">
                          <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('Login') }}</button>
                        </div>
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
