@extends('backend.layouts.public-app')
@section('content')
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
                        <label class="form-check-label k-cursor" for="remember">{{ __('Remember Me') }}</label>
                      </div>
                    </div>
                    <div class="mb-2 d-grid gap-2">
                      <button class="btn k-btn k-btn-primary btn-block" type="submit">{{ __('Login') }}</button>
                    </div>
                    @if (Route::has('password.request'))
                    <div class="mt-4 text-center">
                      <p class="semibold-text mb-2"><a href="{{ route('password.request') }}" data-toggle="flip" class="k-link">{{ __('Forgot Your Password?') }}</a></p>
                    </div>
                    @endif
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
@endsection