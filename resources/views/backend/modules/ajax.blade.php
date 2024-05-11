@if(isset($data) && count($data)>0)
@php
$record_id = $offset;
@endphp
<table class="table k-table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Singular Name</th>
      <th>Model Name</th>
      <th>Controller Name</th>
      <th>Date Created</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $v)
    <tr class="row_{{ $v->id }}">
      <td>{{ ++$record_id }}</td>
      <td><a href="{{ $v->show_route }}">{{$v->name}}</a></td>
      <td>{{$v->name_singular}}</td>
      <td>{{$v->model_name}}</td>
      <td>{{$v->controller_name}}</td>
      <td>{{ Date('d M, Y',strtotime($v->created_at)) }}</td>
      <td>
        @if($v->deleted_at==null)
        <!-- <a href="{{ $v->edit_route }}" class="btn k-btn-sm k-btn-primary btn-sm">Edit</a> -->
        <a href="#" data-id="{{ $v->id }}" class="btn k-btn-sm k-btn-danger btn-sm delete_btn delete{{ $v->id }}">Delete</a>
        @endif
      </td>
    </tr>
    <?php $page_number++ ?>

    @endforeach
  <tbody>
</table>
<div class="text-muted p-2"></div>
@else
<div class="alert alert-warning" align="center">
  Opps, seems like records not available.
</div>
@endif
@if($pagination['total_records']>$pagination['item_per_page'])
<div class="pl-3">
  <div class="paging_simple_numbers">
    <ul class="pagination">
      <?php
      echo paginate_function($pagination['item_per_page'], $pagination['current_page'], $pagination['total_records'], $pagination['total_pages']);
      ?>
    </ul>
  </div>
</div>
@endif