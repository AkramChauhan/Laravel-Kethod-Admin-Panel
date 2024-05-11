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
            @if($edit)
            <input type="hidden" value="{{$data->id}}" name="id">
            @endif

            <div class="row form_sec">
              <div class="col-12">
                <h5>Basic Details</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="key">Key</label>
                  <input type="text" name="key" class="form-control k-input" @if($edit) value="{{$data->key}}" @else value="{{old('key')}}" @endif id="key" aria-describedby="keyHelp">
                  <small id="keyHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
            @if($edit && $data->key == 'THEME')
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name">Value</label>
                  <select name="value" class="form-control k-input" id="value">
                    <?php
                    $selected = "";
                    if ($edit && $data->value == 'theme-2') {
                      $selected = "selected";
                    }
                    ?>
                    <option value="theme-1">theme-1</option>
                    <option value="theme-2" {{ $selected }}>theme-2</option>
                  </select>
                  <small id="valueHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
            @else
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name">Value</label>
                  <textarea rows=5 type="text" name="value" class="form-control k-input" id="value" aria-describedby="valueHelp">@if($edit){{ $data->value }}@endif</textarea>
                  <small id="valueHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
            @endif


            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <button type="submit" class="btn k-btn k-btn-primary add_site">
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