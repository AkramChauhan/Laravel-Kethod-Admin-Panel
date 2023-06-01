@extends('theme.layouts.app')
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
              <div class="col-12">
                <h5>Basic Details</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="site_name">Name</label>
                  <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name']['value'] }}" id="site_name" aria-describedby="site_nameHelp">
                  <small id="site_nameHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="site_url">URL</label>
                  <input type="text" name="site_url" class="form-control" value="{{ $settings['site_url']['value'] }}" id="site_url" aria-describedby="site_urlHelp">
                  <small id="site_urlHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tagline">Tagline</label>
                  <input type="text" name="tagline" class="form-control" value="{{ $settings['tagline']['value'] }}" id="tagline" aria-describedby="taglineHelp">
                  <small id="taglineHelp" class="form-text text-muted"></small>
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