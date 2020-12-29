@extends('themes.vali-bootstrap.layouts.app')

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
    <p>A free and open source Bootstrap 4 admin template</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Welcome {{ Auth::user()->name }}</strong> Your are logged in as <strong>{{ Auth::user()->role }}</strong>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
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