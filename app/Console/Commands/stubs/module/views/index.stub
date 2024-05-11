@extends($app_layout)
@section('content')
<?php
$page_number = 1;
?>
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
    </div>
    @include($theme_name.'.layouts.partial.breadcrumb')
    <div class="col-md-12">
      <?php
      ($table_status == "all") ? $all_status = 'selected' : $all_status = '';
      ($table_status == "trashed") ? $trash_status = 'selected' : $trash_status = '';
      ?>
      <div class="row">
        <div class="col-12 py-3">
          <input type="hidden" class="action_selected" value="trash">
          <div class="row justify-content-between align-items-center">
            <div class="col-7">
              <div class="d-flex align-items-center">
                <div class="px-2 trash_selected_button bulk_select_btn">
                  <button class="btn k-btn k-btn-primary trash_selected" name="trash_selected">Trash Selected</button>
                </div>
                <div class="px-2 restore_selected_button bulk_select_btn">
                  <button class="btn k-btn k-btn-primary delete_selected" name="delete_selected">Delete Selected</button>
                </div>
                <div class="col-4">
                  <input type="hidden" name="page_number" id="page_number" class="page_number" value="{{ $page_number }}">
                  <div class="input-group pr-2">
                    <input type="text" class="form-control k-input search" name="search" id="search" placeholder="Search by Name">
                  </div>
                </div>
                <div class="buttons px-2">
                  <button class="btn k-btn k-btn-primary pl-2 search_data">Search</button>
                  <button class="btn k-btn k-btn-primary pl-2 reset_data">Reset</button>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="d-flex justify-content-end align-items-center">
                <div class="trashed px-2">
                  <div class="input-group">
                    <input type="hidden" class="all_trashed_input" value="{{ $table_status }}">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Display</label>
                    </div>
                    <select class="custom-select form-select change_display" id="inputGroupSelect01">
                      <option {{ $all_status }} value="all">All ({{ $all_count }})</option>
                      <option {{ $trash_status }} value="trashed">Trashed ({{ $trashed_count }})</option>
                    </select>
                  </div>
                </div>
                <div class="limit px-2">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Row</label>
                    </div>
                    <select class="custom-select form-select change_row_limit" id="inputGroupSelect01">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                </div>
                <div class="add-btn">
                  <a class="btn k-btn k-btn-primary ml-2" href="{{$create_route}}">Add</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-0">
          <div class="ajax_loader p-3 text-center"><img src="{{ asset('backend/assets/images/ajax_loader_circular.gif') }}" alt=""></div>
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
<script src="{{ asset('backend/assets/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  function load_data() {
    $(".load_data").html('');
    $(".ajax_loader").show();

    var token = '{{ csrf_token() }}';
    var limit = $(".change_row_limit option:selected").val();
    var page_number = $(".page_number").val();
    var string = $(".search").val();
    var all_trashed = $(".change_display option:selected").val();

    $.ajax({
      type: 'GET',
      url: '{{ $ajax_route }}',
      data: {
        _token: token,
        page_number: page_number,
        string: string,
        all_trashed: all_trashed,
        limit: limit
      },
      success: function(html) {
        $(".ajax_loader").hide();
        $(".load_data").html(html);
        // perform pagination.
        $(".page-link").click(function(e) {
          e.preventDefault();
          page_number = $(this).attr('data-page');
          $(".page_number").val(page_number);
          load_data();
        });

        //Trash Item
        $(".trash_btn").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "It will be trashed from the system!";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'trash',
                    is_bulk: 0,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "It has been trashed successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });

        //Delete Item
        $(".delete_btn").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "It will be deleted from the system!";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'delete',
                    is_bulk: 0,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "Item has been deleted successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });

        //Restore Item
        $(".restore_btn").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "Item will be restored!";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'restore',
                    is_bulk: 0,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "It has been restored successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });

        //Changing parent checkbox
        $(".row_check_all").change(function(e) {
          var action = $('.action_selected').val();
          if (this.checked) {
            $('.row_checkbox').prop('checked', true);
            var checkbox_vals = [];
            $('.row_checkbox').each(function() {
              (this.checked ? checkbox_vals.push($(this).val()) : "");
            });
            $("." + action + "_selected_button").show();
            $("." + action + "_selected_button button").attr('data-id', checkbox_vals);
          } else {
            $("." + action + "_selected_button").hide();
            $("." + action + "_selected_button button").attr('data-id', '');
            $('.row_checkbox').prop('checked', false);
          }
        });

        //Changing child checkbox
        $(".row_checkbox").change(function(e) {
          var checkbox_vals = [];
          $('.row_checkbox').each(function() {
            (this.checked ? checkbox_vals.push($(this).val()) : "");
          });
          var action = $('.action_selected').val();
          if (checkbox_vals.length > 0) {
            $("." + action + "_selected_button").show();
            $("." + action + "_selected_button button").attr('data-id', checkbox_vals);
          } else {
            $("." + action + "_selected_button button").attr('data-id', '');
            $("." + action + "_selected_button").hide();
          }
        });

        // Trash selected.
        $(".trash_selected").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "One or more items will be trashed !";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'trash',
                    is_bulk: 1,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "Items are trashed successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });

        // Delete selected.
        $(".delete_selected").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "One or more items will be deleted !";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'delete',
                    is_bulk: 1,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "Items are deleted successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });

        // Restore selected.
        $(".restore_selected").click(function(e) {
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          // var data_status = $(this).attr('data-status');
          var status_msg = "One or more items will be deleted !";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                var token = '{{ csrf_token() }}';
                $.ajax({
                  type: 'POST',
                  url: '{{ $delete_route }}',
                  data: {
                    _token: token,
                    data_id: data_id,
                    action: 'restore',
                    is_bulk: 1,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "Items has been restored successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
              }
            });
        });
      },
    });
  }
  $(document).ready(function() {
    $(".bulk_select_btn").hide();
    // $(".restore_selected_button").hide();
    load_data();
    $(".change_row_limit").change(function() {
      load_data();
    });

    $(".change_display").change(function(e) {
      $(".bulk_select_btn").hide();
      e.preventDefault();
      temp = $(this).val();
      $(".all_trashed_input").val(temp);
      if (temp == "all") {
        $(".action_selected").val('trash');
      } else {
        $(".action_selected").val('restore');
      }
      load_data();
    });

    $(".search_data").click(function(e) {
      e.preventDefault();
      load_data();
    });
    $(".reset_data").click(function(e) {
      e.preventDefault();
      $(".search").val('');
      load_data();
    });
  });
</script>
@endpush
@endsection