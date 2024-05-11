<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Log;

/**
 * Created by Akram Chauhan
 */

function kview($view_path, $array = []) {
  $theme_name = "backend";
  $new_v_path = $theme_name . "." . $view_path;
  $layout_name = $theme_name . ".layouts.app";
  $array['app_layout'] = $layout_name;
  $array['theme_name'] = $theme_name;
  $array['new_v_path'] = $new_v_path;
  return view($new_v_path, $array);
}

function default_permissions() {
  return [
    'list',
    'update',
    'add',
  ];
}
function get_setting($key) {
  $settingObject = Setting::select('value')->where('key', $key)->first();
  if ($settingObject) {
    $setting = $settingObject->toArray();
    return $setting['value'];
  }
  return "";
}

function verifySlug($table, $slug_name, $str) {
  $existing_slug =  $table::where($slug_name, 'like', $str . '%')->orderBy('id', 'desc');
  if ($existing_slug->count() > 0) {
    $db_obj = $existing_slug->first();
    $slug_name = $db_obj->slug;
    $slug_arr = explode("-", $slug_name);
    $count_slug_arr = count($slug_arr);
    $last_slug_str = $slug_arr[$count_slug_arr - 1];
    // dd(($last_slug_str));
    if (ctype_digit($last_slug_str)) {
      $last_slug_num = (int)$last_slug_str + 1;
      $slug_arr[$count_slug_arr - 1] = $last_slug_num;
    } else {
      $slug_arr[$count_slug_arr] = 1;
    }
    $str = implode("-", $slug_arr);
  }
  return $str;
}

function singular_module_name($plural) {
  // Remove non-alphabetic characters and underscores
  $plural = preg_replace('/[^a-zA-Z_]/', '', $plural);

  // Convert to lowercase for case-insensitive processing
  $plural = strtolower($plural);

  // Apply the rule to transform "ies" to "y"
  if (preg_match('/(ies)$/i', $plural)) {
    return preg_replace('/(ies)$/i', 'y', $plural);
  }

  // Define common plural rules
  $rules = array(
    '/(s)$/i' => '',
    '/((sh)es|ces|xes|zes)$/i' => '$2',
    '/(([^f])ves)$/i' => '$2fe',
    '/((ss))$/i' => '$1',
    '/(ies)$/i' => 'ie',
    '/(ch|x)ies$/i' => '$1ie',
    '/(ves)$/i' => 'fe',
    '/(o)es$/i' => '$1',
    '/(us)es$/i' => '$1s',
    '/([^u])s$/i' => '$1',
  );

  // Apply the remaining rules to convert plural to singular
  foreach ($rules as $pattern => $replacement) {
    if (preg_match($pattern, $plural, $matches)) {
      return preg_replace($pattern, $replacement, $plural);
    }
  }

  // If no rule matched, return the original word
  return $plural;
}

function paginate_function($item_per_page, $current_page, $total_records, $total_pages) {
  $pagination = '';
  if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number
    $right_links  = $current_page + 3;
    $previous    = $current_page - 3; //previous link 
    $next     = $current_page + 1; //next link
    $first_link  = true; //boolean var to decide our first link

    if ($current_page > 1) {
      $previous_link = ($previous <= 0) ? 1 : $previous;
      $pagination .= '<li class="page-item "><a class="paginate_link page-link"  href="#" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
      $pagination .= '<li class="page-item "><a class="paginate_link page-link"  href="#" aria-controls="datatable1" data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link
      for ($i = ($current_page - 2); $i < $current_page; $i++) { //Create left-hand side links
        if ($i > 0) {
          $pagination .= '<li class="page-item "><a class="paginate_link page-link"  href="#" data-page="' . $i . '" aria-controls="datatable1" title="Page' . $i . '">' . $i . '</a></li>';
        }
      }
      $first_link = false; //set first link to false
    }

    if ($first_link) { //if current active page is first link
      $pagination .= '<li class="page-item active">
        <a class="paginate_link page-link" aria-controls="datatable1">' . $current_page . '</a></li>';
    } elseif ($current_page == $total_pages) { //if it's the last active link
      $pagination .= '<li class="page-item active">
        <a class="paginate_link page-link" aria-controls="datatable1">' . $current_page . '</a></li>';
    } else { //regular current link
      $pagination .= '<li class="page-item active">
        <a class="paginate_link page-link" aria-controls="datatable1">' . $current_page . '</a></li>';
    }

    for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links
      if ($i <= $total_pages) {
        $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
      }
    }
    if ($current_page < $total_pages) {
      $next_link = ($i > $total_pages) ? $total_pages : $i;
      $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="' . $next_link . '" title="Next">&gt;</a></li>'; //next link
      $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>'; //last link
    }
  }
  return $pagination; //return pagination links
}

function snakeCaseToPascalCase($snake) {
  $words = explode('_', $snake);  // Split the snake case string into an array of words
  $pascal = '';
  foreach ($words as $word) {
    $pascal .= ucfirst($word);  // Capitalize the first letter of each word and append it to the PascalCase string
  }
  return $pascal;
}

function getColumnTypes() {
  $pairs = [
    'integer' => 'INTEGER',
    'bigInteger' => 'BIG INTEGER',
    'tinyInteger' => 'BOOLEAN',
    'date' => 'DATE',
    'dateTime' => 'DATE AND TIME',
    'text' => 'TEXT',
    'longText' => 'LONG TEXT',
    'string' => 'VARCHAR',
    'decimal' => 'DECIMAL',
    'double' => 'DOUBLE',
  ];
  return $pairs;
}

function getColumnTypeSchema($type) {
  $pairs = getColumnTypes();
  return $pairs[$type];
}

function snakeToNormal($snake) {
  $words = explode('_', $snake);  // Split the snake_case string into an array of words
  $normal = '';
  foreach ($words as $word) {
    $normal .= ucfirst($word) . ' ';  // Capitalize the first letter of each word and add a space after it
  }
  return trim($normal);  // Remove trailing whitespace and return the human-readable string
}
