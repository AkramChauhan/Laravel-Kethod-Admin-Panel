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
                <div class="mb-3">
                  <label for="SITE_NAME">Name</label>
                  <input type="text" name="SITE_NAME" class="form-control" value="{{ $settings['SITE_NAME']['value'] }}" id="SITE_NAME" aria-describedby="SITE_NAMEHelp">
                  <small id="SITE_NAMEHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="site_url">URL</label>
                  <input type="text" name="site_url" class="form-control" value="{{ $settings['SITE_URL']['value'] }}" id="site_url" aria-describedby="site_urlHelp">
                  <small id="site_urlHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="tagline">Tagline</label>
                  <input type="text" name="tagline" class="form-control" value="{{ $settings['TAGLINE']['value'] }}" id="tagline" aria-describedby="taglineHelp">
                  <small id="taglineHelp" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="instagram_cookie">Instagram Cookie</label>
                  <textarea rows=5 name="instagram_cookie" class="form-control" id="INSTAGRAM_COOKIE" aria-describedby="instagram_cookieHelp">{{ $settings['instagram_cookie']['value'] }}</textarea>
                  <small id="instagram_cookieHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <button type="submit" class="btn k-btn k-btn-primary add_site">
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