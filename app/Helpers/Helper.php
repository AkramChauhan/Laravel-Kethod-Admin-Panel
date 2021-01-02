<?php
/**
 * Created by PhpStorm.
 * User: SST5
 * Date: 12/12/2019
 * Time: 11:17 AM
 */

function kview($view_path,$array=[]){
  $app_theme=config('app.theme');
  $new_v_path = 'themes.'.$app_theme.'.'.$view_path;
  return view($new_v_path, $array);
}
?>