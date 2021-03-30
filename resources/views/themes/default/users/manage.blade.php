@extends('themes.default.layouts.app')
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

            <div class="col-md-12 form_page">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $form_action }}" class="" method="post">
                            @csrf
                            @if($edit)
                                <input type="hidden" value="{{$data->id}}" name="id">
                            @endif

                            <div class="row form_sec">
                                <div class="col-12"><h5>Basic Details</h5></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" @if($edit) value="{{$data->name}}" @else value="{{old('name')}}" @endif id="name" aria-describedby="nameHelp">
                                        <small id="nameHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tagline">Email</label>
                                        <input type="text" name="email" class="form-control" @if($edit) value="{{$data->email}}" @else value="{{old('email')}}" @endif  id="tagline" aria-describedby="taglineHelp">
                                        <small id="taglineHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                            <select class="form-control" name="role">
                                            <option value="">No Roles</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" <?php if($edit && $data->role_id==$role->id){ echo 'selected'; }else if(old('role')==$role->id){ echo "selected"; } ?>>{{$role->name}}</option>
                                            @endforeach
                                            </select>
                                        <small id="domainHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="password" class="form-control" id="old_password" aria-describedby="old_passwordHelp">
                                        <small id="old_passwordHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" class="form-control" id="new_password" aria-describedby="new_passwordHelp">
                                        <small id="new_passwordHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" aria-describedby="new_password_confirmationHelp">
                                        <small id="new_password_confirmationHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary add_site">
                                            @if($edit)
                                                Update
                                            @else
                                                Add
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
