@extends('themes.sb-admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">{{ __('Two Factor Verification') }}</h3></div>
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
                <div class="card-footer text-center">
                    <div class="small">Code will be expired within 10 mins.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
