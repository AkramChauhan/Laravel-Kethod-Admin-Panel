@extends('backend.layouts.public-app')
@section('content')
<section class="login-content py-5">
  <div class="container">
    <div style="height:75vh" class="row justify-content-center align-items-center">
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
                    {{ config('app.name') }}
                  </h5>
                  <div class="col-12 text-center">
                    @if (Route::has('login'))
                    <div class="top-right links">
                      @auth
                      <a class="btn k-btn k-btn-primary" href="{{ route('admin.dashboard') }}">Home</a>
                      @else
                      <a class="btn k-btn k-btn-primary" href="{{ route('login') }}">Login</a>

                      @if (Route::has('register'))
                      <a class="btn k-btn k-btn-primary" href="{{ route('register') }}">Register</a>
                      @endif
                      @endauth
                    </div>
                    @endif
                  </div>
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