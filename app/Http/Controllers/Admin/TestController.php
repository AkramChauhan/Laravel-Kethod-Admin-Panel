<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller {
  public function someFunction() {
    return 1;
  }
  public function test() {
    return $this->someFunction();
  }
}
