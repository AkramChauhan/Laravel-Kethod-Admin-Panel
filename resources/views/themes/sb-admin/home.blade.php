@extends('themes.sb-admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        @foreach($dashboard_cards as $card)
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body"> 
                    <h4><i class="icon {{ $card[3] }}"></i> {{ $card[0] }}
                    <p class="float-right"><b><?php echo number_format($card[1]); ?></b></p></h4>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ ($card[2]) }}">View Details</a>
                        <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
