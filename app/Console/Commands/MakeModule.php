<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class MakeModule extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:module {module_name} {--name_singular=} {--migration} {--column_data=}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new module in admin panel with crud operations';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle() {
    $argument = $this->argument('module_name');
    $options = $this->options();
    $data = $this->option('column_data');
    $col_data = [];
    if ($this->option('column_data')) {
      $col_data = json_decode(base64_decode($this->option('column_data')), true);
    }
    if ($this->option('name_singular')) {
      $singular_snake_case = $this->option('name_singular');
    } else {
      $singular_snake_case = singular_module_name($argument);
    }
    $run_migration = 0;
    if (isset($options['migration']) && $options['migration']) {
      $run_migration = 1;
    }

    //Lets create names first.
    //Expecting argument to be snake_case
    // SNAKECASE -> snake_case
    // PASCALCASE -> PascalCase
    $table_name = $argument;
    $model_name = snakeCaseToPascalCase($singular_snake_case);
    $migration_class_name = snakeCaseToPascalCase($table_name);
    $controller_name = snakeCaseToPascalCase($singular_snake_case) . "Controller";
    $normal_plural = snakeToNormal($table_name);
    $normal_singular = snakeToNormal($singular_snake_case);
    $migration_file_name = date('Y_m_d_His') . '_create_' . str_replace('-', '_', $table_name) . '_table';
    $migrationFiles = glob(database_path('migrations/*_create_' . $table_name . '_table.php'));
    $name_generation = [
      "Table name" => $table_name,
      "Resource dir name" => $table_name,
      "Model name" => $model_name,
      "Controller name" => $controller_name,
      "Normal name" => $normal_plural,
      "Normal name singular" => $normal_singular,
      "Migration file name" => $migration_file_name,
    ];
    if (count($migrationFiles) > 0) {
      $this->error("Migration file for table $table_name exists.");
      return 0;
    } else {
      $this->info("Creating migration file...");
    }

    $col_names = [];
    $request_required_fields = [];
    foreach ($col_data as $cols) {
      $request_required_fields[$cols['name']] = 'required';
      array_push($col_names, $cols['name']);
    }
    // MODIFY MODEL FILE based on COLDATA
    $stub = file_get_contents(__DIR__ . '/stubs/module/model.stub');
    $stub = str_replace('{MODEL_NAME}', $model_name, $stub);
    $stub = str_replace('{MODULE_NAME}', $table_name, $stub);

    if (count($col_names) >= 1) {
      $fillableArrayString = "'" . implode("',\n        '", array_values($col_names)) . "',";
      $stub = str_replace(
        "protected \$fillable = [\n        'name', \n    ];",
        "protected \$fillable = [\n        $fillableArrayString\n    ];",
        $stub
      );
    }

    $path = app_path('Models/' . $model_name . '.php');
    file_put_contents($path, $stub);
    $this->info('Model created successfully!');

    // Creating add/update requests        
    $stub = file_get_contents(__DIR__ . '/stubs/module/request.stub');

    $new_data_string = var_export($request_required_fields, true);
    $new_data_string = preg_replace('/^/m', "\t\t", $new_data_string);

    // $stub = preg_replace("/\\\$data\s*=\s*\[.*?\];/s", '$data = ' . $new_data_string . ';', $stub);
    $stub = preg_replace("/\\\$data\s*=\s*\[.*?\];/s", "\$data = " . $new_data_string . ";", $stub);

    $add_stub = str_replace('{MODEL_NAME}', $model_name, $stub);
    $add_stub = str_replace('{REQUEST_NAME}', "Add" . $model_name, $add_stub);
    //Checking if directory available.
    $directory = app_path('Http/Requests/' . $model_name . 'Requests');
    if (!File::exists($directory)) {
      try {
        File::makeDirectory($directory, 0755, true, true);
      } catch (\Exception $e) {
        $this->error("Could not create directory: $directory");
        $this->info("Please check that the parent directory exists and is writable.");
        return;
      }
    }
    if (!is_writable($directory)) {
      $this->error("The directory '$directory' is not writable.");
      $this->info("Please adjust the directory's permissions and try again.");
      return;
    }
    $path = $directory . '/Add' . $model_name . '.php';
    file_put_contents($path, $add_stub);

    $update_stub = str_replace('{MODEL_NAME}', $model_name, $stub);
    $update_stub = str_replace('{REQUEST_NAME}', "Update" . $model_name, $update_stub);

    //Checking if directory available.
    $directory = app_path('Http/Requests/' . $model_name . 'Requests');
    $path = $directory . '/Update' . $model_name . '.php';
    file_put_contents($path, $update_stub);
    $this->info('Request pages created successfully!');

    // Creating controller file.
    $stub = file_get_contents(__DIR__ . '/stubs/module/controller.stub');
    $stub = str_replace('{MODEL_NAME}', $model_name, $stub);
    $stub = str_replace('{CONTROLLER_NAME}', $controller_name, $stub);
    $stub = str_replace('{SINGULAR_TABLE_NAME}', $singular_snake_case, $stub);
    $stub = str_replace('{TABLE_NAME}', $table_name, $stub);
    if (count($col_names) >= 1) {
      foreach ($col_names as $col_name) {
        $new_col_update_data[$col_name] = '$request->' . $col_name;
      }
      // Constructing the new data string manually
      $new_data_string = '[';
      foreach ($new_col_update_data as $key => $value) {
        $new_data_string .= "'$key' => $value, ";
      }
      $new_data_string .= ']';
      // Replace the existing data array with the new one
      $stub = preg_replace("/\\\$data\s*=\s*\[.*?\];/s", '$data = ' . $new_data_string . ';', $stub);
    }

    $path = app_path('Http/Controllers/Admin/' . $controller_name . '.php');
    $generatedFilePath = file_put_contents($path, $stub);
    $this->info('Controller created successfully!');

    // Format file too
    // exec('npx prettier --write ' . $generatedFilePath);

    // Creating controller file.
    $stub = file_get_contents(__DIR__ . '/stubs/module/migration.stub');
    $path = database_path('migrations/' . $migration_file_name . '.php');
    $stub = str_replace('{MIGRATION_CLASS_NAME}', "Create" . $migration_class_name . "Table", $stub);
    $stub = str_replace('{TABLE_NAME}', $table_name, $stub);

    $new_lines = [];
    $ajax_header_lines = [];
    $ajax_body_lines = [];
    $manage_body_lines = [];
    $show_body_lines = [];
    $manage_script_lines = "";
    if (count($col_names) >= 1) {
      // Define the new lines you want to replace with
      foreach ($col_data as $col) {
        $col_type = $col['type'];
        $col_name = "'" . $col['name'] . "'";
        $col_name_copy = "'" . $col['name'] . "'";
        $new_line = "\$table->$col_type($col_name)";
        if ($col['nullable']) {
          $new_line .= "->nullable()";
        }
        $new_line .= ";";
        array_push($new_lines, $new_line);
        if ($col_type == "longText") {
          $manage_body_line = '<div class="col-md-12">
                  <div class="mb-3">
                    <label for="' . $col['name'] . '">' . snakeToNormal($col['name']) . '</label>
                    <textarea 
                      name="' . $col['name'] . '"
                      rows="10" class="form-control tiny-cloud-editor k-input" 
                      id="' . $col['name'] . '" 
                      aria-describedby="' . $col['name'] . 'Help">@if($edit){{$data->' . $col['name'] . '}}@else{{old(' . $col_name_copy . ')}}@endif</textarea>
                    <small id="' . $col['name'] . 'Help" class="form-text text-muted"></small>
                  </div>
                </div>';
          $show_body_line = '<div class="col-md-12">
                  <div class="mb-3">
                    <label for="' . $col['name'] . '">' . snakeToNormal($col['name']) . '</label>
                    <hr />
                    <?php echo ($data->' . $col['name'] . '); ?>
                  </div>
                </div>';
          $manage_script_lines = <<<EOD
            \n@push("scripts")
            <script src="https://cdn.tiny.cloud/1/rjcn06xon4v0snhiv3rvotq9163xs47zt4tx0sdp6izhg8o3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
              tinymce.init({
                selector: ".tiny-cloud-editor",
                skin: "bootstrap",
                plugins: "lists, link, image, media",
                toolbar: "h1 h2 h3 h4 h5 | fontfamily fontsize | bold italic strikethrough blockquote | align lineheight bullist numlist backcolor | link ",
                menubar: false,
              });
            </script>
            @endpush
          EOD;
        } else {
          array_push($ajax_header_lines, "<th>" . snakeToNormal($col['name']) . "</th>");
          if (count($ajax_body_lines) == 0) {
            array_push($ajax_body_lines, "<td><a href='{{ \$v->show_route }}'>{{ \$v->" . $col['name'] . " }}</a></td>");
          } else {
            array_push($ajax_body_lines, "<td>{{ \$v->" . $col['name'] . " }}</td>");
          }

          $manage_body_line = '<div class="col-md-6">
                  <div class="mb-3">
                    <label for="' . $col['name'] . '">' . snakeToNormal($col['name']) . '</label>
                    <input 
                      type="text"
                      name="' . $col['name'] . '" 
                      class="form-control k-input" 
                      @if($edit) 
                        value="{{$data->' . $col['name'] . '}}"
                      @else 
                        value="{{old(' . $col_name_copy . ')}}" 
                      @endif 
                      id="' . $col['name'] . '" 
                      aria-describedby="' . $col['name'] . 'Help">
                    <small id="' . $col['name'] . 'Help" class="form-text text-muted"></small>
                  </div>
                </div>';
          $show_body_line = '<div class="col-md-6">
                  <div class="mb-3">
                    <label for="' . $col['name'] . '">' . snakeToNormal($col['name']) . '</label>
                    <input 
                      type="text"
                      class="form-control k-input" 
                      value="{{$data->' . $col['name'] . '}}"
                      disabled
                      >
                  </div>
                </div>';
        }

        array_push($manage_body_lines, $manage_body_line);
        array_push($show_body_lines, $show_body_line);
      }

      // Construct the new content string
      $new_content = implode("\n				", $new_lines);
      // Replace the existing content with the new content
      $stub = preg_replace("/\\\$table->string\('name'\);/", $new_content, $stub);
    }
    // TODO: change
    file_put_contents($path, $stub);
    $this->info('Migration created successfully!');

    // Create a directory in resources folder for the views.
    $stubDirectory = __DIR__ . '/stubs/module/views';
    $viewDirectory = resource_path("views/backend/{$table_name}");
    if (!File::exists($viewDirectory)) {
      File::makeDirectory($viewDirectory, 0755, true);
    }
    $stubFiles = [
      'index.stub' => 'index.blade.php',
      'manage.stub' => 'manage.blade.php',
      'ajax.stub' => 'ajax.blade.php',
      'show.stub' => 'show.blade.php',
    ];
    foreach ($stubFiles as $stubFile => $viewFile) {
      $fullStubPath = "{$stubDirectory}/{$stubFile}";
      $fullViewPath = "{$viewDirectory}/{$viewFile}";

      // Read the content of the stub file
      $stubContent = file_get_contents($fullStubPath);

      // Modify the content of ajax.stub before copying
      if ($stubFile === 'ajax.stub') {
        // Change the line <th>Name</th> to <th>Name1</th><th>Name2</th>
        $newAjaxHeaderContent = "<!-- ajax table header -->" . implode("\n			", $ajax_header_lines);
        $newAjaxBodyContent = "<!-- ajax table body -->" . implode("\n			", $ajax_body_lines);
        $stubContent = str_replace('<!-- ajax table header -->', $newAjaxHeaderContent, $stubContent);
        $stubContent = str_replace('<!-- ajax table body -->', $newAjaxBodyContent, $stubContent);
      }
      if ($stubFile === 'manage.stub') {
        $stubContent = str_replace(
          '<div class="col-md-6"><div class="mb-3"><label for="name">Name</label><input type="text" name="name" class="form-control k-input" @if($edit) value="{{$data->name}}" @else value="{{old("name")}}" @endif id="name" aria-describedby="nameHelp"><small id="nameHelp" class="form-text text-muted"></small></div></div>',
          implode("\n							", $manage_body_lines),
          $stubContent
        );
        $stubContent .= $manage_script_lines;
      }
      if ($stubFile === 'show.stub') {
        $stubContent = str_replace(
          '<div class="col-md-6"><div class="mb-3"><label for="name">Name</label><input type="text" value="{{$data->name}}" class="form-control k-input" disabled></div></div>',
          implode("\n							", $show_body_lines),
          $stubContent
        );
      }
      // Copy the modified content to the blade file
      file_put_contents($fullViewPath, $stubContent);
    }
    $this->info("Views for {$table_name} created successfully.");

    // Add new route
    // Define the new route group
    // Append the new routes to the existing group in the routes file
    $fullControllerName = "Admin\\" . $controller_name;
    $newRoute = [

      "// For $normal_plural",
      "Route::get('$table_name', '$fullControllerName@index')->name('admin.$table_name.index');",
      "Route::get('$table_name/add', '$fullControllerName@create')->name('admin.$table_name.create');",
      "Route::get('$table_name/edit/{encrypted_id}', '$fullControllerName@edit')->name('admin.$table_name.edit');",
      "Route::get('$table_name/show/{encrypted_id}', '$fullControllerName@show')->name('admin.$table_name.show');",
      "Route::post('$table_name/store', '$fullControllerName@store')->name('admin.$table_name.store');",
      "Route::post('$table_name/update', '$fullControllerName@update')->name('admin.$table_name.update');",
      "Route::get('$table_name/ajax', '$fullControllerName@ajax')->name('admin.$table_name.ajax');",
      "Route::post('$table_name/delete', '$fullControllerName@delete')->name('admin.$table_name.delete');",
    ];

    $this->appendRoutesToGroup($newRoute);
    $this->info("New routes added.");

    // Update menu file
    // Add new element to menu array
    $menuFile = resource_path('views/configuration/menu_array.blade.php');
    // Create the new menu array
    $newMenuItem =  [
      "name" => $normal_plural,
      "icon" => "fa fa-file",
      "dropdown" => true,
      "route" => "",
      "dropdown_items" => [
        [
          "name" => "Add " . $normal_singular,
          "icon" => "fa fa-circle-o",
          "route" => "admin." . $table_name . ".create"
        ],
        [
          "name" => "Manage " . $normal_plural,
          "icon" => "fa fa-circle-o",
          "route" => "admin." . $table_name . ".index"
        ],
      ],
    ];
    $menuContents = file_get_contents($menuFile);
    $menuContents = str_replace('<?php', '', $menuContents);
    eval($menuContents);
    $menu[] = $newMenuItem;
    $newMenuContents = "<?php\n\n\$menu = " . var_export($menu, true) . ";\n";
    file_put_contents($menuFile, $newMenuContents);

    $this->info("Menu updated successfully.");

    Artisan::call('route:cache');
    if ($run_migration) {
      Artisan::call('migrate');
    }

    $this->info("New module has been created and added to admin panel.");

    return 0;
  }

  function appendRoutesToGroup(array $newRoutes) {
    $routesFile = base_path('routes/web.php');

    // Get the contents of the routes file
    $routesContents = file_get_contents($routesFile);

    // Define the regular expression pattern to match the route group
    $pattern = "/Route::middleware\(\[(.*?)\]\)->prefix\(\'admin\'\)->group\(function\s*\(\)\s*{(.*?)\}\s*\);\s*\n/s";

    // Check if the pattern matches in the routes file
    if (preg_match($pattern, $routesContents, $matches)) {
      $routeGroup = $matches[0];
      // Append the new routes to the route group
      foreach ($newRoutes as $route) {
        $routeGroup = str_replace("});", "  $route\n});", $routeGroup);
      }

      // Replace the old route group with the new one
      $routesContents = str_replace($matches[0], $routeGroup, $routesContents);

      // Write the modified contents back to the routes file
      file_put_contents($routesFile, $routesContents);
    }
  }
}
