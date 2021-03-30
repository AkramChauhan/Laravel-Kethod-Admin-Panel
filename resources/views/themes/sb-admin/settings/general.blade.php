@extends('themes.sb-admin.layouts.app')
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
                           
                            <div class="row form_sec">
                                <div class="col-12"><h5>Basic Details</h5></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ config('app.name') }}" id="name" aria-describedby="nameHelp">
                                        <small id="nameHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input type="text" name="url" class="form-control" value="{{ config('app.url') }}" id="url" aria-describedby="urlHelp">
                                        <small id="urlHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="theme">Theme</label>
                                        <select name="theme" class="form-control">
                                            <option value="default" <?php if(config('app.theme')=="default"){ echo "selected"; } ?>>Default</option>
                                            <option value="sb-admin" <?php if(config('app.theme')=="sb-admin"){ echo "selected"; } ?>>SB Admin</option>
                                            <option value="vali-bootstrap" <?php if(config('app.theme')=="vali-bootstrap"){ echo "selected"; } ?>>Vali Boostrap</option>
                                        </select>
                                        <small id="themeHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary add_site">
                                            Update
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
