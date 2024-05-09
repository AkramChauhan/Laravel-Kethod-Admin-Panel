<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ModuleController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index() {
    $form_action = route('admin.module.create');

    return kview('module.index', compact('form_action'));
  }
  public function create(Request $request) {
    $module_name = $request->module_name;
    $command = "make:module " . $module_name;

    if (!$module_name) {
      return redirect()->back()->with('error', "Module name can't be empty");
    }
    if (isset($request->run_migrations) && $request->run_migrations == "on") {
      $command .= " --migration";
    }

    if ($request->column_count > 1) {
      $cols = json_decode($request->column_names, true);
      $schema_columns = [];

      foreach ($cols as $column) {
        $column_name = $column . "_name";
        $column_type = $column . "_type";
        $column_length = $column . "_length";
        $column_nullable = $column . "_nullable";

        // Ensure all required keys exist and are non-empty
        if (!empty($request->$column_name) && !empty($request->$column_type) && !empty($request->$column_length) && isset($request->$column_nullable)) {
          $column_data = [
            'name' => $request->$column_name,
            'type' => $request->$column_type,
            'length' => $request->$column_length,
            'nullable' => $request->$column_nullable === "nullable" ? true : false
          ];

          // Add column data to the schema_columns array
          $schema_columns[$column] = $column_data;
        } else {
          // Handle missing or empty values
          // You may want to add error handling or logging here
        }
      }
    }
    // Check if there are more than one schema_columns
    if (!empty($schema_columns)) {
      $command .= " --column_data=" . base64_encode(json_encode($schema_columns));
    }
    Artisan::call($command);
    Artisan::call('route:cache');
    sleep(3);
    return redirect()->to(route('admin.module.index'))->with('success', 'New module has been created.');
  }
}
