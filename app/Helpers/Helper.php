<?php

use App\Models\Setting;

/**
 * Created by Akram Chauhan
 */

function kview($view_path, $array = []) {
  $settings = Setting::all()->keyBy('key');
  $app_theme = $settings['theme']['value'];
  $new_v_path = 'themes.' . $app_theme . '.' . $view_path;
  return view($new_v_path, $array);
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
