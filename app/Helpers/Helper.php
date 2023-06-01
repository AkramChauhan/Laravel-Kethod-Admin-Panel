<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Log;

/**
 * Created by Akram Chauhan
 */

function kview($view_path, $array = []) {
  $new_v_path = 'theme.' . $view_path;
  return view($new_v_path, $array);
}

function default_permissions() {
  return [
    'list',
    'update',
    'add',
  ];
}
function getSettings() {
  $settings = [
    'site_name' => [
      'value' => config('app.name')
    ],
    'site_url' => [ 
      'value' => config('app.url'),
    ],
    'tagline' => [ 
      'value' => "Tagline",
    ],
  ];
  try {
    $new_settings =  Setting::all()->keyBy('key');
    // dd($new_settings);
    if ($new_settings->count() > 0 ) {
      $settings = $new_settings;
    }
  } catch (Exception $e) {
    // dd($e);
    Log::info("Error while loading the settings:", [$e]);
    return $settings;
  }
  return $settings;
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
  $last = substr($plural, -1);  // Get the last character of the plural noun

  // Check for some common special cases
  if ($plural == 'people') {
    return 'person';
  } elseif ($plural == 'children') {
    return 'child';
  } elseif ($plural == 'oxen') {
    return 'ox';
  }

  // Apply the basic rules for forming singulars
  if ($last == 's') {
    $secondLast = substr($plural, -2, 1);  // Get the second-to-last character
    if ($secondLast == 'e') {
      return substr($plural, 0, -2) . 'is';  // e.g. "cacti"
    } elseif ($secondLast == 'e' && substr($plural, -3, 1) == 'i') {
      return substr($plural, 0, -2) . 'us';  // e.g. "fungi"
    } elseif ($last == 's' && substr($plural, -4) == 'sses') {
      return substr($plural, 0, -2);  // e.g. "messes"
    } else {
      return substr($plural, 0, -1);  // e.g. "dogs"
    }
  } else {
    return $plural;  // Not a valid plural noun
  }
}

function snakeCaseToPascalCase($snake) {
  $words = explode('_', $snake);  // Split the snake case string into an array of words
  $pascal = '';
  foreach ($words as $word) {
    $pascal .= ucfirst($word);  // Capitalize the first letter of each word and append it to the PascalCase string
  }
  return $pascal;
}

function snakeToNormal($snake) {
  $words = explode('_', $snake);  // Split the snake_case string into an array of words
  $normal = '';
  foreach ($words as $word) {
    $normal .= ucfirst($word) . ' ';  // Capitalize the first letter of each word and add a space after it
  }
  return trim($normal);  // Remove trailing whitespace and return the human-readable string
}
