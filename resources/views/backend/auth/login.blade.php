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
  <section class="login-content py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-4 py-3">
                @if(session()->has('message'))
                <div class="alert alert-info">{{ session()->get('message') }}</div>
                @endif
                <div class="card login-card">
                  <div class="card-body">
                    <div class="logo text-center">
                      <img class="img-fluid logo-img" src="{{ asset('backend/assets/images/kethod.png') }}" alt="Kethod" />
                    </div>
                    <h5 class="mb-4 text-center">
                      {{ __('Log in to continue') }}
                    </h5>
                    <form class="login-form" method="POST" action="{{ route('login') }}">
                      @csrf
                      <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" class="form-control k-input @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input id="password" class="form-control k-input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="mb-3 form-check">
                        <div class="utility">
                          <input type="checkbox" name="remember" class="form-check-input k-input" id="remember">
                          <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                          @if (Route::has('password.request'))
                          <p class="semibold-text mb-2"><a href="{{ route('password.request') }}" data-toggle="flip">{{ __('Forgot Your Password?') }}</a></p>
                          @endif
                        </div>
                      </div>
                      <div class="mb-2">
                        <button class="btn k-btn k-btn-primary btn-block" type="submit">{{ __('Login') }}</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('backend/assets/plugins/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('backend/assets/plugins/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
  
  @stack('scripts')
</body>

</html>