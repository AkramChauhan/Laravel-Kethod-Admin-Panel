@if(isset($data) && count($data)>0)
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date Created</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr class="row_{{ $v->id }}">
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->email}}</td>
                <td>{{$v->created_at}}</td>
                <td>
                    <a href="{{$edit_route.'?id='.$v->id}}" class="btn btn-primary">Edit</a>
                </td>
            </tr>
        <?php $page_number++ ?>

        @endforeach
        <tbody>
    </table>
@else
    <div class="alert alert-warning" align="center">
        Opps, seems like sites not available for current filter.
    </div>
@endif
