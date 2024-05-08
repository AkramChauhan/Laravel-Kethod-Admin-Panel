@extends('backend.layouts.public-app')
@section('content')
<section class="confirm-password-content py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-4 py-3">
              @if(session()->has('message'))
              <div class="alert alert-info">{{ session()->get('message') }}</div>
              @endif
              @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
              @endif
              <div class="card login-card">
                <div class="card-body">
                  <div class="logo text-center">
                    <img class="img-fluid logo-img" src="{{ asset('backend/assets/images/kethod.png') }}" alt="Kethod" />
                  </div>
                  <h5 class="mb-4 text-center">
                    {{ __('Confirm Password') }}
                  </h5>
                  <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label" for="password">{{ __('Password') }}</label>
                      <input id="password" type="password" class="form-control k-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>

                    <div class="mb-3 d-grid gap-2">
                      <button type="submit" class="btn k-btn k-btn-primary">
                        {{ __('Confirm Password') }}
                      </button>
                    </div>

                    <div class="mt-4 text-center">
                      <p class="semibold-text mb-2"><a href="{{ route('login') }}" data-toggle="flip" class="k-link">{{ __('Back to login?') }}</a></p>
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
@endsection