@extends('themes.default.layouts.app')
@section('content')
    <?php
    $page_number = 1;
    ?>
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
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <input type="hidden" name="page_number" id="page_number" class="page_number" value="{{ $page_number }}">
                            <div class="input-group mb-3 pr-2">
                                <input type="text" class="form-control search" name="search" id="search" placeholder="Search by Display Name">
                            </div>
                        </div>
                        <button class="btn btn-primary pl-2 search_data">Search</button>
                        <button class="btn btn-primary pl-2 reset_data">Reset</button>
                        <div class="float-right">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Row</label>
                                </div>
                                <select class="custom-select change_row_limit" id="inputGroupSelect01">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                                <button class="btn btn-primary ml-2 reset_data" onclick="window.location.href='{{$create_route}}'">Add</button>
                              </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="ajax_loader p-3" align="center"><img src="{{ asset('themes/'.config('app.theme').'/images/ajax_loader.gif') }}" alt=""></div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="load_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push("scripts")
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            function load_data(){
                $(".load_data").html('');
                $(".ajax_loader").show();

                var token = '{{ csrf_token() }}';
                var limit = $(".change_row_limit option:selected").val();
                var page_number = $(".page_number").val();
                var string =  $(".search").val();
                var league_uid = $(".league_uid option:selected").val();

                $.ajax({
                    type: 'GET',
                    url: '{{ $ajax_route }}',
                    data: {_token: token, page_number: page_number,league_uid:league_uid, string:string, limit:limit},
                    success: function (html) {
                        $(".ajax_loader").hide();
                        $(".load_data").html(html);
                        // perform pagination.
                        $(".page-link").click(function(e){
                            e.preventDefault();
                            page_number = $(this).attr('data-page');
                            $(".page_number").val(page_number);
                            load_data();
                        });
                    },
                });
            }
            $(document).ready(function(){
                load_data();
                $(".change_row_limit").change(function(){
                    load_data();
                });
                $(".search_data").click(function(e){
                    e.preventDefault();
                    load_data();
                });
                $(".reset_data").click(function(e){
                    e.preventDefault();
                    $(".search").val('');
                    load_data();
                });
            });
        </script>
    @endpush
@endsection
