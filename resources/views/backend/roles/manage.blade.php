@extends($app_layout)
@section('content')
<div class="container page-container">
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
            </div>
          </div>
        </div>
        <br />
        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Permissions</h5>
                <hr />
              </div>
            </div>
            <?php
            $default_permissions = default_permissions();
            $existing_permissions = [];
            if ($edit) {
              $existing_permissions = ($data->getPermissionNames()->toArray());
              // dd($existing_permissions);
            }
            ?>
            <div class="row">
              <!-- Permission for Users -->
              <div class="col-md-3">
                <h6>Users</h6>
                <hr />
                @foreach($default_permissions as $user_permission)
                <?php
                $temp_permission = "user-" . $user_permission;
                $temp_permission_label = "User " . ucfirst($user_permission);
                $temp_checked = "";
                if (in_array($temp_permission, $existing_permissions)) {
                  $temp_checked = "checked";
                }
                ?>
                <div class="mb-3">
                  <input type="checkbox" {{ $temp_checked }} name="permissions[{{ $temp_permission }}]" id="{{ $temp_permission }}" aria-describedby="{{ $temp_permission }}Help">
                  <label for="{{ $temp_permission }}">{{ $temp_permission_label }}</label>
                </div>
                @endforeach
              </div>

              <!-- Permission for Roles -->
              <div class="col-md-3">
                <h6>Roles</h6>
                <hr />
                @foreach($default_permissions as $role_permission)
                <?php
                $temp_permission = "role-" . $role_permission;
                $temp_permission_label = "Role " . ucfirst($role_permission);
                $temp_checked = "";
                if (in_array($temp_permission, $existing_permissions)) {
                  $temp_checked = "checked";
                }
                ?>
                <div class="mb-3">
                  <input type="checkbox" {{ $temp_checked }} name="permissions[{{ $temp_permission }}]" id="{{ $temp_permission }}" aria-describedby="{{ $temp_permission }}Help">
                  <label for="{{ $temp_permission }}">{{ $temp_permission_label }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <br />
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