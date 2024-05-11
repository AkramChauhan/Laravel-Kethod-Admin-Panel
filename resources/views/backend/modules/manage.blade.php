@extends($app_layout)
@push('styles')
<style>
  .hidden {
    display: none;
  }
</style>
@endpush
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
    @include($theme_name.'.layouts.partial.breadcrumb')

    <div class="col-md-12 form_page">
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
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control k-input module-name" @if($edit) value="{{$data->name}}" @else value="{{old('name')}}" @endif id="name" aria-describedby="nameHelp">
                  <small id="nameHelp" class="form-text text-muted"><i>Table name: must be plural</i></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name_singular">Name Singular</label>
                  <input type="text" name="name_singular" class="form-control k-input name_singular" @if($edit) value="{{$data->name}}" @else value="{{old('name')}}" @endif id="name_singular" aria-describedby="name_singularHelp">
                  <small id="name_singularHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <h5>Schema Details <a href="#" class="add-col"><i class="fa fa-plus"></i></a> </h5>
                <p class="text-muted">Auto-increment ID and timestamp will be auto added to the table schema.</p>
                <br />
              </div>
              <div class="container cols">
                <input type="hidden" name="total_cols" class="total_cols" value="1">
                <input type="hidden" name="column_count" class="column_count" value="1">
                <input type="hidden" name="column_names" class="column_names" value="">
                <div class="row column col1" data-item="col1">
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="col1_name">Column Name</label>
                      <input type="text" name="col1_name" class="form-control k-input" value="name" id="col1_name" aria-describedby="col1_nameHelp">
                      <small id="col1_nameHelp" class="form-text text-muted"></small>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="col1_type">Column Type</label>
                      <select name="col1_type" class="form-control">
                        @foreach($col_types as $col_type_key => $col_type_value)
                        <?php
                        $selected = "";
                        if ($col_type_key == "string") {
                          $selected = "selected";
                        }
                        ?>
                        <option {{ $selected }} value="{{ $col_type_key }}">{{ $col_type_value }}</option>
                        @endforeach
                      </select>
                      <small id="col1_typeHelp" class="form-text text-muted"></small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label for="col1_length">Length</label>
                      <input type="text" name="col1_length" class="form-control k-input" value="40" id="col1_length" aria-describedby="col1_lengthHelp">
                      <small id="col1_lengthHelp" class="form-text text-muted"></small>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="col1_nullable">Default</label>
                      <select name="col1_nullable" class="form-control">
                        <option value="nullable">Null</option>
                        <option value="not_null">Not Null</option>
                      </select>
                      <small id="col1_nullableHelp" class="form-text text-muted"></small>
                    </div>
                  </div>
                  <div class="col-md-1">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Auto run migrations?</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label class="switch">
                  <input type="checkbox" name="run_migrations" class="run_migrations k-input" id="run_migrations">
                  <span class="slider"></span>
                </label>
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
<!-- Hidden template for the new col -->
<div class="col-template hidden">
  <div class="row column col-new" data-item="col-new">
    <div class="col-md-3">
      <div class="mb-3">
        <label for="col-new_name">Column Name</label>
        <input type="text" name="col-new_name" class="form-control k-input" value="" placeholder="Enter column name" id="col-new_name" aria-describedby="col-new_nameHelp">
        <small id="col-new_nameHelp" class="form-text text-muted"></small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="col-new_type">Column Type</label>
        <select name="col-new_type" class="form-control">
          @foreach($col_types as $col_type_key => $col_type_value)
          <option value="{{ $col_type_key }}">{{ $col_type_value }}</option>
          @endforeach
        </select>
        <small id="col-new_typeHelp" class="form-text text-muted"></small>
      </div>
    </div>
    <div class="col-md-2">
      <div class="mb-3">
        <label for="col-new_length">Length</label>
        <input type="text" name="col-new_length" class="form-control k-input" value="" placeholder="Length of column in database" id="col-new_length" aria-describedby="col-new_lengthHelp">
        <small id="col-new_lengthHelp" class="form-text text-muted"></small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="col-new_nullable">Default</label>
        <select name="col-new_nullable" class="form-control">
          <option value="nullable">Null</option>
          <option value="not_null">Not Null</option>
        </select>
        <small id="col-new_nullableHelp" class="form-text text-muted"></small>
      </div>
    </div>
    <div class="col-md-1">
      <div class="mb-3">
        <label for=""></label>
        <div>
          <button type="button" data-class="col-new" class="remove-col btn"><i class="fa fa-remove fa-2x"></i> </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push("scripts")
<script type="text/javascript">
  function updateTotalCountOfColumns() {
    var columnCount = $('.column:not(.col-template .column)').length;
    var columnNamesArray = [];
    // Loop through all elements with class "column" excluding those inside ".col-template"
    $('.column:not(.col-template .column)').each(function() {
      // Get the column name from the data-item attribute
      var columnName = $(this).data('item');
      // Push the column name to the array
      columnNamesArray.push(columnName);
    });
    $('.column_names').val(JSON.stringify(columnNamesArray));
    $('.column_count').val(columnCount);
  }
  $(document).ready(function(e) {
    updateTotalCountOfColumns();
    $(".add-col").on('click', (e) => {
      e.preventDefault();
      var totalCols = $('.total_cols').val();
      var newCol = $('.col-template .row.col-new').clone();
      var newColNumber = parseInt(totalCols) + 1;
      var newColClassName = 'col' + (newColNumber);

      var htmlContent = newCol.html().replace(/col-new/g, newColClassName);
      newCol.html(htmlContent);

      newCol.find('.col-new').parent().removeClass('col-new').addClass(newColClassName);
      newCol.first().removeClass('col-new').addClass(newColClassName);
      newCol.first().attr('data-item', newColClassName);

      $('.cols').append(newCol);
      $('.total_cols').val(newColNumber);
      updateTotalCountOfColumns();
    });

    $('.cols').on('click', '.remove-col', function(e) {
      e.preventDefault();
      var target_class = $(this).attr('data-class');
      console.log(target_class);
      $("." + target_class).remove();
      updateTotalCountOfColumns();
    });
    $(".module-name").on('keyup', function(e) {
      var plural = $(this).val();
      var singular = pluralToSingular(plural);
      $('.name_singular').val(singular);
    });
  });
</script>
@endpush