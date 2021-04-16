@extends('themes.default.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Two Factor Verification') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('verify.store') }}">
                        @csrf
                        <p class="text-muted">You have recieved an email which contain verification code.
                        If you haven't received it, Click <a href="{{ route('verify.resend') }}">here</a>
                        </p>
                        <div class="form-group row">
                          <label for="two_factor_code" class="col-md-12 col-form-label">{{ __('Two Factor Code') }}</label>
                          <div class="col-md-12">
                              <input id="two_factor_code" type="text" class="form-control @error('two_factor_code') is-invalid @enderror" name="two_factor_code" required autofocus>

                              @error('two_factor_code')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
