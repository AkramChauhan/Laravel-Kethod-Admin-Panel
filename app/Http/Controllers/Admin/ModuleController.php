<?php

namespace App\Http\Controllers\Admin;

use App\Models\Module as Table;
use App\Models\ModuleSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

use Exception;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller {
  protected $handle_name = "module";
  protected $handle_name_plural = "modules";

  public function index() {
    $all_count = Table::count();
    $trashed_count = Table::onlyTrashed()->count();
    return kview($this->handle_name_plural . '.index', [
      'ajax_route' => route('admin.' . $this->handle_name_plural . '.ajax'),
      'delete_route' => route('admin.' . $this->handle_name_plural . '.delete'),
      'create_route' => route('admin.' . $this->handle_name_plural . '.create'),
      'table_status' => 'all', //all , trashed
      'all_count' => $all_count,
      'module_names' => [
        'singular' => $this->handle_name,
        'plural' => $this->handle_name_plural,
      ],
      'trashed_count' => $trashed_count,
    ]);
  }

  public function create() {
    $form_action = route('admin.modules.store');
    $index_route = route('admin.' . $this->handle_name_plural . '.index');
    $col_types = getColumnTypes();
    $edit = 0;
    $module_names = [
      'singular' => $this->handle_name,
      'plural' => $this->handle_name_plural,
    ];
    return kview($this->handle_name_plural . '.manage', compact('form_action', 'index_route', 'module_names', 'col_types', 'edit'));
  }

  public function edit(Request $request) {
    $col_types = getColumnTypes();
    $ecrypted_id = $request->encrypted_id;
    $id = Crypt::decryptString($ecrypted_id);
    $data = Table::where('id', '=', $id)->first();
    $index_route = route('admin.' . $this->handle_name_plural . '.index');
    return kview($this->handle_name_plural . '.manage', [
      'index_route' => $index_route,
      'form_action' => route('admin.' . $this->handle_name_plural . '.update'),
      'col_types' => $col_types,
      'edit' => 1,
      'data' => $data,
      'module_names' => [
        'singular' => $this->handle_name,
        'plural' => $this->handle_name_plural,
      ],
    ]);
  }


  public function show(Request $request) {
    $ecrypted_id = $request->encrypted_id;
    $id = Crypt::decryptString($ecrypted_id);
    $data = Table::where('id', '=', $id)->first();

    return kview($this->handle_name_plural . '.show', [
      'form_action' => route('admin.' . $this->handle_name_plural . '.update'),
      'edit' => 1,
      'data' => $data,
      'module_names' => [
        'singular' => $this->handle_name,
        'plural' => $this->handle_name_plural,
      ],
    ]);
  }

  public function store(Request $request) {
    $module_name = $request->name;
    $name_singular = $request->name_singular;
    $run_module = 1;
    if (isset($request->run_module)) {
      $run_module = $request->run_module;
    }

    $run_migration = 0;
    if (!$module_name) {
      return redirect()->back()->with('error', "Module name can't be empty");
    }
    if (isset($request->run_migrations) && $request->run_migrations == "on") {
      $run_migration = 1;
    }

    if (isset($request->column_count) && $request->column_count >= 1) {
      $cols = json_decode($request->column_names, true);
      $schema_columns = [];
      foreach ($cols as $column) {
        $column_name = $column . "_name";
        $column_type = $column . "_type";
        $column_length = $column . "_length";
        $column_nullable = $column . "_nullable";

        // Ensure all required keys exist and are non-empty
        if (
          !empty($request->$column_name) &&
          !empty($request->$column_type)
        ) {
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

    // STORING MODULE IN DB:
    // $name_singular = singular_module_name($module_name);
    $model_name = snakeCaseToPascalCase($name_singular);
    $controller_name = snakeCaseToPascalCase($name_singular) . "Controller";

    $module = Table::updateOrCreate(
      [
        'name' => $module_name,
      ],
      [
        'name' => $module_name,
        'name_singular' => $name_singular,
        'model_name' => $model_name,
        'controller_name' => $controller_name,
        'run_migration' => $run_migration,
      ]
    );
    if (isset($schema_columns)) {
      foreach ($schema_columns as $key => $cols) {

        $where = [
          'col_name' => $cols['name'],
          'module_id' => $module->id,
        ];
        $data = [
          'module_id' => $module->id,
          'col_name' => $cols['name'],
          'col_type' => $cols['type'],
          'col_length' => $cols['length'] ?? 0,
          'is_nullable' => $cols['nullable'] ? 1 : 0,
          'is_index' => 0,
        ];
        ModuleSchema::updateOrCreate(
          $where,
          $data,
        );
      }
    }
    if ($run_module == 1) {
      $this->run_module($module);
    }
    return redirect()->to(route('admin.modules.index'))->with('success', 'New module has been created.');
  }

  public function update(Request $request) {
    $module_name = $request->module_name;
    $name_singular = $request->name_singular;

    $run_module = 1;
    if (isset($request->run_module)) {
      $run_module = $request->run_module;
    }

    $run_migration = 0;
    if (!$module_name) {
      return redirect()->back()->with('error', "Module name can't be empty");
    }
    if (isset($request->run_migrations) && $request->run_migrations == "on") {
      $run_migration = 1;
    }

    if (isset($request->column_count) && $request->column_count >= 1) {
      $cols = json_decode($request->column_names, true);
      $schema_columns = [];
      foreach ($cols as $column) {
        $column_name = $column . "_name";
        $column_type = $column . "_type";
        $column_length = $column . "_length";
        $column_nullable = $column . "_nullable";

        // Ensure all required keys exist and are non-empty
        if (
          !empty($request->$column_name) &&
          !empty($request->$column_type)
        ) {
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

    // STORING MODULE IN DB:
    // $name_singular = singular_module_name($module_name);
    $model_name = snakeCaseToPascalCase($name_singular);
    $controller_name = snakeCaseToPascalCase($name_singular) . "Controller";

    $module = Table::updateOrCreate(
      [
        'name' => $module_name,
      ],
      [
        'name' => $module_name,
        'name_singular' => $name_singular,
        'model_name' => $model_name,
        'controller_name' => $controller_name,
        'run_migration' => $run_migration,
      ]
    );
    if (isset($schema_columns)) {
      foreach ($schema_columns as $key => $cols) {

        $where = [
          'col_name' => $cols['name'],
          'module_id' => $module->id,
        ];
        $data = [
          'module_id' => $module->id,
          'col_name' => $cols['name'],
          'col_type' => $cols['type'],
          'col_length' => $cols['length'] ?? 0,
          'is_nullable' => $cols['nullable'] ? 1 : 0,
          'is_index' => 0,
        ];
        ModuleSchema::updateOrCreate(
          $where,
          $data,
        );
      }
    }
    if ($run_module == 1) {
      $this->run_module($module);
    }
    return redirect()->to($module->show_route)->with('success', ucfirst($this->handle_name) . ' has been updated');
  }


  public function run_module(Table $module) {
    $module_name = $module->name;
    $name_singular = $module->name_singular;
    $module_schemas = $module->module_schemas;
    $schema_columns = [];
    $counter = 1;
    foreach ($module_schemas as $schema_column) {
      $key_name = "col" . $counter;
      $schema_columns[$key_name] = [
        'name' => $schema_column['col_name'],
        'type' => $schema_column['col_type'],
        'length' => $schema_column['col_length'],
        'nullable' => $schema_column['is_nullable'] == 1 ? true : false,
      ];
      $counter++;
    }
    $command = "make:module " . $module_name;
    $command .= " --name_singular=" . $name_singular;
    if (!$module_name) {
      return redirect()->back()->with('error', "Module name can't be empty");
    }
    $command .= " --migration";

    if (!empty($schema_columns)) {
      $command .= " --column_data=" . base64_encode(json_encode($schema_columns));
    }
    Artisan::call($command);
    Artisan::call('route:cache');
    sleep(3);
    return true;
  }

  public function ajax(Request $request) {
    $current_page = $request->page_number;
    if (isset($request->limit)) {
      $limit = $request->limit;
    } else {
      $limit = 10;
    }
    $offset = (($current_page - 1) * $limit);
    $modalObject = new Table();
    if (isset($request->string)) {
      $string = $request->string;
      $modalObject = $modalObject->where('name', 'like', "%" . $request->string . "%");
      // $modalObject = $modalObject->orWhere('name','like',"%".$request->string."%");
    }

    $all_trashed = $request->all_trashed;
    if ($all_trashed == "trashed") {
      $modalObject = $modalObject->onlyTrashed();
    }

    $total_records = $modalObject->count();
    $modalObject = $modalObject->offset($offset);
    $modalObject = $modalObject->take($limit);
    $modalObject = $modalObject->orderBy('id', 'desc');
    $data = $modalObject->get();

    if (isset($request->page_number) && $request->page_number != 1) {
      $page_number = $request->page_number + $limit - 1;
    } else {
      $page_number = 1;
    }
    $pagination = array(
      "offset" => $offset,
      "total_records" => $total_records,
      "item_per_page" => $limit,
      "total_pages" => ceil($total_records / $limit),
      "current_page" => $current_page,
    );

    return kview($this->handle_name_plural . '.ajax', compact('data', 'page_number', 'limit', 'offset', 'pagination'));
  }

  public function delete(Request $request) {
    if (isset($request->action)) {
      $action = $request->action;
      $data_id = $request->data_id;
      $module = Table::where('id', $data_id)->first();
      if ($module) {
        $module_name = $module->name;
        $model_name = $module->model_name;
        $controller_name = $module->controller_name;
        $migration_file_name = 'create_' . str_replace('-', '_', $module_name) . '_table.php';

        // First lets rollback that migration.
        $this->removeMigrationFile($migration_file_name);
        $this->removeOtherModuleFiles($module_name, $model_name, $controller_name);
        $this->updateMenuFileAndRouteFiles($module_name, $module->name_singular, $controller_name);
        switch ($action) {
          case 'delete':
            try {
              $table = Table::withTrashed()->find($data_id);
              $table->module_schemas()->forceDelete();
              $data = $table->forceDelete();
              return 1;
            } catch (Exception $e) {
              Log::info('Error while deleting ... ', ['error' => $e->getMessage()]);
              return 0;
            }
            break;
          default:
            return 0;
        }
      }
    }
    return 0;
  }

  public function removeMigrationFile($partialFilename) {
    $migrationsPath = database_path('migrations');

    // Get all files in the migrations directory
    $files = File::files($migrationsPath);

    foreach ($files as $file) {
      // Check if the filename contains the provided partial filename
      if (strpos(basename($file), $partialFilename) !== false) {

        // Migration filename
        $filename = $file->getFilename();
        $command = "migrate:rollback --path=/database/migrations/" . $filename;

        // Rollback the migration
        Artisan::call($command);

        // Delete the file
        File::delete($file);
      }
    }
  }

  public function removeOtherModuleFiles($module_name, $model_name, $controller_name) {
    // Remove model file
    $modelPath = app_path("Models/$model_name.php");
    if (File::exists($modelPath)) {
      File::delete($modelPath);
    }

    // Remove controller file
    $controllerPath = app_path("Http/Controllers/Admin/$controller_name.php");
    if (File::exists($controllerPath)) {
      File::delete($controllerPath);
    }

    // Remove request files
    $addRequestPath = app_path("Http/Requests/" . $model_name . "Requests/Add" . $model_name . ".php");
    if (File::exists($addRequestPath)) {
      File::delete($addRequestPath);
    }
    $updateRequestPath = app_path("Http/Requests/" . $model_name . "Requests/Update" . $model_name . ".php");
    if (File::exists($updateRequestPath)) {
      File::delete($updateRequestPath);
    }
    $requestsDirectory = app_path("Http/Requests/" . $model_name . "Requests");
    if (File::exists($requestsDirectory)) {
      File::deleteDirectory($requestsDirectory);
    }

    // Remove blade files
    $ajaxBladeFilePath = resource_path("views/backend/" . $module_name . "/ajax.blade.php");
    if (File::exists($ajaxBladeFilePath)) {
      File::delete($ajaxBladeFilePath);
    }
    $indexBladeFilePath = resource_path("views/backend/" . $module_name . "/index.blade.php");
    if (File::exists($indexBladeFilePath)) {
      File::delete($indexBladeFilePath);
    }
    $manageBladeFilePath = resource_path("views/backend/" . $module_name . "/manage.blade.php");
    if (File::exists($manageBladeFilePath)) {
      File::delete($manageBladeFilePath);
    }
    $bladeDirectory = resource_path("views/backend/" . $module_name);
    if (File::exists($bladeDirectory)) {
      File::deleteDirectory($bladeDirectory);
    }
  }

  public function updateMenuFileAndRouteFiles($module_name, $normal_singular, $controllerName) {
    $table_name = $module_name;
    $normal_plural = snakeToNormal($table_name);
    $newMenuItem = array(
      "name" => $normal_plural,
      "icon" => "fa fa-file",
      "dropdown" => true,
      "route" => "",
      "dropdown_items" =>
      array(
        0 => array(
          "name" => "Add " . $normal_singular,
          "icon" => "fa fa-circle-o",
          "route" => "admin." . $table_name . ".create"
        ),
        1 => array(
          "name" => "Manage " . $normal_plural,
          "icon" => "fa fa-circle-o",
          "route" => "admin." . $table_name . ".index"
        ),
      ),
    );

    // FROM HERE...
    // Get the path to the menu file
    $menuFile = resource_path('views/configuration/menu_array.blade.php');

    // Read the content of the file
    $content = file_get_contents($menuFile);
    $menu = [];
    // Find the position of the array in the content
    $startPos = strpos($content, '$menu');
    $endPos = strrpos($content, ');');

    if ($startPos !== false && $endPos !== false) {
      // Extract the array part from the content
      $arrayContent = substr($content, $startPos, $endPos - $startPos + 2); // +2 to include the closing PHP tag

      // Parse the PHP code to get the array
      eval($arrayContent);

      // Find and remove the array entry with 'normal_plural' as the 'name' key
      foreach ($menu as $index => $item) {
        if (isset($item['name']) && $item['name'] === $normal_plural) {
          unset($menu[$index]);
        }
      }

      // Re-encode the modified array back to PHP code
      $modifiedArrayContent = '$menu = ' . var_export($menu, true) . ';';

      // Replace the old array content with the modified one
      $newContent = substr_replace($content, $modifiedArrayContent, $startPos, $endPos - $startPos + 2); // +2 to include the closing PHP tag

      // Write the modified content back to the file
      file_put_contents($menuFile, $newContent);
    }

    $controller_name = 'Admin\\' . $controllerName;
    $web_string = '// For ' . $normal_plural;
    $filePath = base_path('routes/web.php');
    $lines = File::lines($filePath);
    $newLines = [];
    $removeProjectComment = false;

    foreach ($lines as $line) {
      if (strpos($line, $web_string) !== false) {
        $removeProjectComment = true;
        continue;
      }

      if ($removeProjectComment && trim($line) === '') {
        continue;
      }

      if (strpos($line, $controller_name) === false) {
        $newLines[] = $line;
      }

      if ($removeProjectComment && !empty(trim($line))) {
        $removeProjectComment = false;
      }
    }

    File::put($filePath, implode("\n", $newLines));
  }
}
