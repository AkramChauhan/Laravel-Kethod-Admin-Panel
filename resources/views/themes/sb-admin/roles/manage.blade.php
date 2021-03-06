@extends('themes.sb-admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add Roles</li>
        </ol>
        <div class="row">
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
                                                <label for="slug">slug</label>
                                                <input type="text" name="slug" class="form-control" @if($edit) value="{{$data->slug}}" @else value="{{old('slug')}}" @endif id="slug" aria-describedby="slugHelp">
                                                <small id="slugHelp" class="form-text text-muted"></small>
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
        </div>
    </div>
@endsection
