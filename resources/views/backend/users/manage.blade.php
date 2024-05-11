@extends($app_layout)
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(session('success'))
      <div class="alert alert-success">
        {{session('success')}}
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
      @endif
    </div>
    @include($theme_name.'.layouts.partial.breadcrumb')

    <div class="col-md-12 form_page">
      <form action="{{ $form_action }}" class="" method="post">
        @csrf
        @if($edit)
        <input type="hidden" value="{{$data->id}}" name="id">
        @endif

        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Basic Details</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control k-input" @if($edit) value="{{$data->name}}" @else value="{{old('name')}}" @endif id="name" aria-describedby="nameHelp">
                  <small id="nameHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="tagline">Email</label>
                  <input type="text" name="email" class="form-control k-input" @if($edit) value="{{$data->email}}" @else value="{{old('email')}}" @endif id="tagline" aria-describedby="taglineHelp">
                  <small id="taglineHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="role">Role</label>
                  <select class="form-control k-input" name="role">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                    <?php
                    $selected = "";
                    if ($edit) {
                      if ($data->hasRole($role)) {
                        $selected = "selected";
                      }
                    }
                    ?>
                    <option value="{{$role->name}}" {{ $selected  }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                  </select>
                  <small id="domainHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              @if($edit)
              <div class="col-12">
                <h5>Change Password (Do not enter if you don't wanted to change it)</h5>
              </div>
              @else
              <div class="col-12">
                <h5>Set Password</h5>
              </div>
              @endif
            </div>
            <div class="row">
              <div class="col-md-6">
                @if($edit)
                <div class="mb-3">
                  <label for="old_password">Old Password</label>
                  <input type="password" name="old_password" autocomplete="new-password" class="form-control k-input" id="old_password" aria-describedby="old_passwordHelp">
                  <small id="old_passwordHelp" class="form-text text-muted"></small>
                </div>
                @endif
                <div class="mb-3">
                  <label for="new_password">New Password</label>
                  <input type="password" name="password" class="form-control k-input" id="new_password" aria-describedby="new_passwordHelp">
                  <small id="new_passwordHelp" class="form-text text-muted"></small>
                </div>
                <div class="mb-3">
                  <label for="new_password_confirmation">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control k-input" id="new_password_confirmation" aria-describedby="new_password_confirmationHelp">
                  <small id="new_password_confirmationHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />
        <!-- <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Two Factor Authentication (Email/SMS)</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label class="switch">
                  <input type="checkbox" name="two_factor_enable" <?php if ($edit) {
                                                                    if ($data->two_factor_enable == 1) {
                                                                      echo 'checked';
                                                                    }
                                                                  } ?> class="two_factor_enable k-input" id="two_factor_enable">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <br /> -->
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn k-btn k-btn-primary add_site">
              @if($edit)
              Update Changes
              @else
              Add User
              @endif
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection