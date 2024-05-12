<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\Admin\ModuleController;
use App\Models\Module as Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleControllerTest extends TestCase {
  use RefreshDatabase;
  protected $user;
  protected $theme = "backend";
  protected $module_name = "modules";
  protected $index_route = "";
  protected $create_route = "";
  protected $update_route = "";
  protected $controller = null;
  protected $mock_data = [
    'name' => "projects",
    'name_singular' => 'project',
  ];
  protected $mock_data_update = [
    'name' => "projects",
    'name_singular' => 'single_project',
  ];

  protected function setUp(): void {

    parent::setUp();
    // Create a user
    /** @var User $user */
    $this->user = User::factory()->create([
      'id' => 111,
    ]);

    // Authenticate the user
    $this->actingAs($this->user);

    // Initialization
    $this->index_route = route('admin.' . $this->module_name . '.index');
    $this->create_route = route('admin.' . $this->module_name . '.create');
    $this->update_route = route('admin.' . $this->module_name . '.update');
    $this->controller = new ModuleController();
  }

  /** @test */
  public function testIndexMethodReturnIndexView() {
    // Invoke the index method of the controller
    $response = $this->get($this->index_route);

    // Assert that the response is successful
    $response->assertStatus(200);

    // Assert that the view returned is 'index'
    $response->assertViewIs($this->theme . '.' . $this->module_name . '.index');
  }

  /** @test */
  public function testCreateMethodReturnManageView() {
    // Invoke the create method of the controller
    $response = $this->get($this->create_route);

    // Assert that the view returned is 'create'
    $response->assertViewIs($this->theme . '.' . $this->module_name . '.manage');
  }

  /** @test */
  public function testEditMethodReturnManageViewWithData() {
    $model = Table::factory()->create([
      'id' => 1,
    ]);

    // Getting table instance
    $modelInstance = Table::first();
    // Create an instance of the controller
    $controller = $this->controller;
    $request = new Request([
      'encrypted_id' => $modelInstance->encrypted_id,
    ]);

    // Call the edit method
    $response = $controller->edit($request);

    // Assert that the response is an instance of a View
    $this->assertInstanceOf(View::class, $response);

    // Assert that the view name manage
    $this->assertEquals($this->theme . '.' . $this->module_name . '.manage', $response->name());

    // Assert that the view data contains the necessary variables
    $this->assertEquals($this->update_route, $response->getData()['form_action']);
    $this->assertEquals($this->index_route, $response->getData()['index_route']);
    $this->assertEquals(1, $response->getData()['edit']);
    $this->assertEquals($model->toArray(), $response->getData()['data']->toArray());
  }

  /** @test */
  public function testShowMethodReturnShowViewWithData() {
    $model = Table::factory()->create([
      'id' => 1,
    ]);

    // Getting table instance
    $modelInstance = Table::first();
    // Create an instance of the controller
    $controller = $this->controller;
    $request = new Request([
      'encrypted_id' => $modelInstance->encrypted_id,
    ]);

    // Call the edit method
    $response = $controller->show($request);

    // Assert that the response is an instance of a View
    $this->assertInstanceOf(View::class, $response);

    // Assert that the view name show
    $this->assertEquals($this->theme . '.' . $this->module_name . '.show', $response->name());
    // Assert that the view data contains the necessary variables
    $this->assertEquals($this->update_route, $response->getData()['form_action']);
    $this->assertEquals(1, $response->getData()['edit']);
    $this->assertEquals($model->toArray(), $response->getData()['data']->toArray());
  }

  /** @test */
  public function testStoreMethodShouldStoreData() {

    // Mock the Request object with fake data
    $request_data = $this->mock_data;
    $request_data['run_module'] = 0;
    $request_data['module_name'] = $this->mock_data['name'];
    $request = new Request($request_data);

    // Call the store method
    $controller = $this->controller;
    $response = $controller->store($request);

    // Assert that the response is a RedirectResponse
    $this->assertInstanceOf(RedirectResponse::class, $response);

    // Assert that the response redirects to the correct route
    $this->assertEquals($this->index_route, $response->getTargetUrl());

    // Assert that the session contains a success message
    $this->assertTrue(session()->has('success'));

    // Assert that the data is stored in the database
    $this->assertDatabaseHas($this->module_name, $this->mock_data);
  }

  /** @test */
  public function testUpdateMethodShouldUpdateData() {

    $this->mock_data['id'] = 11;
    Table::factory()->create($this->mock_data);

    $request_data = $this->mock_data_update;
    $request_data['module_name'] = $this->mock_data_update['name'];
    $request_data['run_module'] = 0;
    $this->mock_data_update['id'] = 11;

    // Mock the Request object with fake data
    $request = new Request($request_data);

    $modelInstance = Table::where('id', 11)->first();
    $this->get($modelInstance->edit_route);

    // Call the update method
    $controller = $this->controller;
    $response = $controller->update($request);

    // Assert that the response is a RedirectResponse
    $this->assertInstanceOf(RedirectResponse::class, $response);

    // Assert that the session contains a success message
    $this->assertTrue(session()->has('success'));

    // Assert that the data is stored in the database
    $this->assertDatabaseHas($this->module_name, $this->mock_data_update);
  }

  /** @test */
  public function testAjaxMethodShouldReturnAjaxViewWithData() {

    // Seed the database with test records
    Table::factory()->count(5)->create();

    // Create an instance of the controller
    $controller = $this->controller;
    $request = new Request([
      'page_number' => 1,
    ]);

    // Call the ajax method
    $response = $controller->ajax($request);

    // Assert that the response is an instance of a View
    $this->assertInstanceOf(View::class, $response);

    // Assert that the view name ajax
    $this->assertEquals($this->theme . '.' . $this->module_name . '.ajax', $response->name());

    $offset = 0;
    $limit = 10;
    $current_page = 1;
    $total_records = Table::count();
    $models = Table::orderBy('id', 'desc')->get();

    $pagination = [
      "offset" => $offset,
      "total_records" => $total_records,
      "item_per_page" => $limit,
      "total_pages" => ceil($total_records / $limit),
      "current_page" => $current_page,
    ];
    // Assert that the view data contains the necessary variables
    $this->assertEquals($current_page, $response->getData()['page_number']);
    $this->assertEquals($limit, $response->getData()['limit']);
    $this->assertEquals($offset, $response->getData()['offset']);
    $this->assertEquals($pagination, $response->getData()['pagination']);
    $this->assertEquals($models->toArray(), $response->getData()['data']->toArray());
  }

  /** @test */
  public function testDeleteMethodShouldDeleteSingleRecord() {
    // Seed the database with test records
    Table::factory()->count(5)->create([
      'name' => 'projects',
    ]);
    // Create an instance of the controller
    $controller = $this->controller;

    $data_id = Table::first()->id;
    $request = new Request([
      'action' => 'delete',
      'is_bulk' => 0,
      'data_id' => $data_id,
    ]);

    // Call the delete method
    $response = $controller->delete($request);
    $this->assertEquals(1, $response);

    $total_records = Table::count();
    $this->assertEquals($total_records, 4);
  }
}
