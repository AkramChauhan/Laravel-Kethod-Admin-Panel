@extends('themes.default.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                
            @endif
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Welcome {{ Auth::user()->name }}</strong> Your are logged in as Administrator.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                @foreach($dashboard_cards as $card)
                    <div class="col-md-3">
                        <a href="{{ ($card[2]) }}" class="card-link">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5"><div class="counter_number"><?php echo number_format($card[1]); ?></div></div>
                                        <div class="col-7"><div class="card-label">{{ $card[0] }}</div></div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    View details
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
