@php
$currentRoute = optional(Request::route())->getName(); // Use optional() to handle null route
if ($currentRoute) {
$excluded = explode(".", $currentRoute);
if (count($excluded) > 2 && isset($excluded[2])) {
$page = $excluded[2];
$page_name = "";
switch ($page) {
case 'index':
$page_name = "List " . ucwords($module_names['plural']);
break;
case 'edit':
$page_name = "Edit " . ucwords($module_names['singular']);
break;
case 'create':
$page_name = "Add " . ucwords($module_names['singular']);
break;
case 'show':
$page_name = "View " . ucwords($module_names['singular']);
break;
default:
$page_name = "";
break;
}
}
}
@endphp

@if(!empty($page_name))
<div class="col-md-12">
  <h4>{{ $page_name }}</h4>
</div>
@endif