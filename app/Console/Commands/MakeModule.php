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
    protected $signature = 'make:module {module_name}';

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

        //Lets create names first.
        //Expecting argument to be snake_case
        $table_name = $argument;
        $singular_snake_case = singular_module_name($argument);
        $model_name = snakeCaseToPascalCase($singular_snake_case);
        $migration_class_name = snakeCaseToPascalCase($table_name);
        $controller_name = snakeCaseToPascalCase($singular_snake_case) . "Controller";
        $normal_plural = snakeToNormal($table_name);
        $normal_singular = snakeToNormal($singular_snake_case);
        $migration_file_name = date('Y_m_d_His') . '_create_' . str_replace('-', '_', $table_name) . '_table';
        $migrationFiles = glob(database_path('migrations/*_create_' . $table_name . '_table.php'));
        if (count($migrationFiles) > 0) {
            $this->error("Migration file for table $table_name exists.");
            return 0;
        } else {
            $this->info("Creating migration file...");
        }

        $name_generation = [
            "Table name" => $table_name,
            "Resource dir name" => $table_name,
            "Model name" => $model_name,
            "Controller name" => $controller_name,
            "Normal name" => $normal_plural,
            "Normal name singular" => $normal_singular,
            "Migration file name" => $migration_file_name,
        ];

        // Creating first model file.
        $stub = file_get_contents(__DIR__ . '/stubs/module/model.stub');
        $stub = str_replace('{MODEL_NAME}', $model_name, $stub);
        $path = app_path('Models/' . $model_name . '.php');
        file_put_contents($path, $stub);
        $this->info('Model created successfully!');

        // Creating add/update requests        
        $stub = file_get_contents(__DIR__ . '/stubs/module/request.stub');

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
        $path = app_path('Http/Controllers/Admin/' . $controller_name . '.php');
        file_put_contents($path, $stub);
        $this->info('Controller created successfully!');

        // Creating controller file.
        $stub = file_get_contents(__DIR__ . '/stubs/module/migration.stub');
        $path = database_path('migrations/' . $migration_file_name . '.php');
        $stub = str_replace('{MIGRATION_CLASS_NAME}', "Create" . $migration_class_name . "Table", $stub);
        $stub = str_replace('{TABLE_NAME}', $table_name, $stub);
        file_put_contents($path, $stub);
        $this->info('Migration created successfully!');

        // Create a directory in resources folder for the views.
        $stubDirectory = __DIR__ . '/stubs/module/views';
        $viewDirectory = resource_path("views/theme/{$table_name}");
        if (!File::exists($viewDirectory)) {
            File::makeDirectory($viewDirectory, 0755, true);
        }
        $stubFiles = [
            'index.stub' => 'index.blade.php',
            'manage.stub' => 'manage.blade.php',
            'ajax.stub' => 'ajax.blade.php',
        ];
        foreach ($stubFiles as $stubFile => $viewFile) {
            $fullStubPath = "{$stubDirectory}/{$stubFile}";
            $fullViewPath = "{$viewDirectory}/{$viewFile}";
            File::copy($fullStubPath, $fullViewPath);
        }
        $this->info("Views for {$table_name} created successfully.");

        // Add new route
        // Define the new route group
        // Append the new routes to the existing group in the routes file

        $newRoute = [
            "// For $normal_plural",
            "Route::get('$table_name/', [$controller_name::class, 'index'])->name('admin.$table_name.index');",
            "Route::get('$table_name/add', [$controller_name::class, 'create'])->name('admin.$table_name.create');",
            "Route::get('$table_name/edit', [$controller_name::class, 'edit'])->name('admin.$table_name.edit');",
            "Route::post('$table_name/store', [$controller_name::class, 'store'])->name('admin.$table_name.store');",
            "Route::post('$table_name/update', [$controller_name::class, 'update'])->name('admin.$table_name.update');",
            "Route::get('$table_name/ajax', [$controller_name::class, 'ajax'])->name('admin.$table_name.ajax');",
            "Route::post('$table_name/delete', [$controller_name::class, 'delete'])->name('admin.$table_name.delete');",
            "",
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

        Artisan::call('migrate');
        Artisan::call('route:cache');

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
