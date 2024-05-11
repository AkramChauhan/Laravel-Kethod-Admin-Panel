@php
$currentRoute = Request::route()->getName();
$excluded = explode(".",$currentRoute);
if (count($excluded) > 2 && isset($excluded[2])) {
$page = $excluded[2];
$page_name = "";
if ($page == 'index') {
$page_name = "List ".ucwords($module_names['plural']);
} else if ($page == 'edit') {
$page_name = "Edit ".ucwords($module_names['singular']);
} else if ($page == 'create'){
$page_name = "Add ".ucwords($module_names['singular']);
} else {
$page_name = "";
}
@endphp
<div class="col-md-12">
  <h4>{{ $page_name }}</h4>
</div>
@php
}
@endphp