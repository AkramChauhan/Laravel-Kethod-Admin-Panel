@extends('theme.layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif
  </div>

  @foreach($dashboard_cards as $card)
    <div class="col-md-6 col-lg-3">
      <a href="{{ ($card[2]) }}" class="card-hover">
        <div class="widget-small primary coloured-icon">
          <i class="icon {{ $card[3] }} fa-3x"></i>
          <div class="info">
            <h4>{{ $card[0] }}</h4>
            <p><b><?php echo number_format($card[1]); ?></b></p>
          </div>
        </div>
      </a>
    </div>
  @endforeach
</div>
@endsection