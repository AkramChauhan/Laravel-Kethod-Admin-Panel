@extends($app_layout)
@section('content')
<div class="container page-container">
  <div class="row justify-content-center">
    @include($theme_name.'.layouts.partial.breadcrumb')
    <div class="col-md-12">
      @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>

      @endif
      <div class="row">
        @foreach($dashboard_cards as $card)
        <div class="col-md-3">
          <a href="{{ ($card[2]) }}" class="card-link">
            <div class="card bg-dark text-white mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="counter_number"><?php echo number_format($card[1]); ?></div>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                {{ $card[0] }}
                <div class="small text-white"><i class="fa fa-angle-right"></i></div>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection