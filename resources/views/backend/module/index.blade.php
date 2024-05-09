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

    <div class="col-md-12 form_page">
      <h4>Create Module</h4><br />
      <form action="{{ $form_action }}" class="" method="post">
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Module Details</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="module_name">Name</label>
                  <input type="text" name="module_name" class="form-control k-input" value="{{old('module_name')}}" id="module_name" aria-describedby="module_nameHelp">
                  <small id="module_nameHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />

        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn k-btn k-btn-primary add_site">
              Create Module
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection