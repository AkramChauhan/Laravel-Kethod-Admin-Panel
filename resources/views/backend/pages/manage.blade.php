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
              <div class="col text-end">
                <a href="{{ $index_route }}" class="btn k-btn k-btn-primary text-right">View All</a>
                @if($edit)
                <a href="{{ $data->edit_route }}" class="btn k-btn k-btn-primary text-right add_site">Edit</a>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label for="name">Name</label>
                    <input 
                      type="text"
                      name="name" 
                      class="form-control k-input" 
                      @if($edit) 
                        value="{{$data->name}}"
                      @else 
                        value="{{old('name')}}" 
                      @endif 
                      id="name" 
                      aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted"></small>
                  </div>
                </div>
							<div class="col-md-12">
                  <div class="mb-3">
                    <label for="content">Content</label>
                    <textarea 
                      name="content"
                      rows="10" class="form-control tiny-cloud-editor k-input" 
                      id="content" 
                      aria-describedby="contentHelp">@if($edit){{$data->content}}@else{{old('content')}}@endif</textarea>
                    <small id="contentHelp" class="form-text text-muted"></small>
                  </div>
                </div>
            </div>
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
@push("scripts")
  <script src="https://cdn.tiny.cloud/1/rjcn06xon4v0snhiv3rvotq9163xs47zt4tx0sdp6izhg8o3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: ".tiny-cloud-editor",
      skin: "bootstrap",
      plugins: "lists, link, image, media",
      toolbar: "h1 h2 h3 h4 h5 | fontfamily fontsize | bold italic strikethrough blockquote | align lineheight bullist numlist backcolor | link ",
      menubar: false,
    });
  </script>
  @endpush