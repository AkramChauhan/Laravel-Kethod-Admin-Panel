<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('home');

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => true, // Password Reset Routes...
  'verify' => true, // Email Verification Routes...
]);

Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::middleware(['auth', 'twofactor'])->prefix('admin')->group(function () {
  // Test Route
  Route::get('/test', "TestController@test")->name('admin.test');

  // For Dashboard
  Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

  // For Module
  Route::get('/modules', 'Admin\ModuleController@index')->name('admin.modules.index');
  Route::get('/modules/add', "Admin\ModuleController@create")->name('admin.modules.create');
  Route::get('/modules/edit/{encrypted_id}', "Admin\ModuleController@edit")->name('admin.modules.edit');
  Route::get('/modules/show/{encrypted_id}', "Admin\ModuleController@show")->name('admin.modules.show');
  Route::post('/modules/store', "Admin\ModuleController@store")->name('admin.modules.store');
  Route::post('/modules/update', "Admin\ModuleController@update")->name('admin.modules.update');
  Route::get('/modules/ajax', "Admin\ModuleController@ajax")->name('admin.modules.ajax');
  Route::post('/modules/delete', "Admin\ModuleController@delete")->name('admin.modules.delete');

  // For Users
  Route::get('/users', 'UserController@index')->name('admin.users.index');
  Route::get('/users/add', "UserController@create")->name('admin.users.create');
  Route::get('/users/edit/{encrypted_id}', "UserController@edit")->name('admin.users.edit');
  Route::get('/users/show/{encrypted_id}', "UserController@show")->name('admin.users.show');
  Route::post('/users/store', "UserController@store")->name('admin.users.store');
  Route::post('/users/update', "UserController@update")->name('admin.users.update');
  Route::get('/users/ajax', "UserController@ajax")->name('admin.users.ajax');
  Route::post('/users/delete', "UserController@delete")->name('admin.users.delete');

  // For Roles
  Route::get('/roles', 'RoleController@index')->name('admin.roles.index');
  Route::get('/roles/add', "RoleController@create")->name('admin.roles.create');
  Route::get('/roles/edit', "RoleController@edit")->name('admin.roles.edit');
  Route::get('/roles/show/{encrypted_id}', "RoleController@show")->name('admin.roles.show');
  Route::post('/roles/store', "RoleController@store")->name('admin.roles.store');
  Route::post('/roles/update', "RoleController@update")->name('admin.roles.update');
  Route::get('/roles/ajax', "RoleController@ajax")->name('admin.roles.ajax');
  Route::post('/roles/delete', "RoleController@delete")->name('admin.roles.delete');

  // For Page
  Route::get('/pages', 'Admin\PageController@index')->name('admin.pages.index');
  Route::get('/pages/add', "Admin\PageController@create")->name('admin.pages.create');
  Route::get('/pages/edit/{encrypted_id}', "Admin\PageController@edit")->name('admin.pages.edit');
  Route::get('/pages/show/{encrypted_id}', "Admin\PageController@show")->name('admin.pages.show');
  Route::post('/pages/store', "Admin\PageController@store")->name('admin.pages.store');
  Route::post('/pages/update', "Admin\PageController@update")->name('admin.pages.update');
  Route::get('/pages/ajax', "Admin\PageController@ajax")->name('admin.pages.ajax');
  Route::post('/pages/delete', "Admin\PageController@delete")->name('admin.pages.delete');

  // For Settings
  Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings.index');
  Route::get('/settings/add', "Admin\SettingController@create")->name('admin.settings.create');
  Route::get('/settings/edit/{encrypted_id}', "Admin\SettingController@edit")->name('admin.settings.edit');
  Route::get('/settings/show/{encrypted_id}', "Admin\SettingController@show")->name('admin.settings.show');
  Route::get('/settings/edit_profile', "Admin\SettingController@edit_profile")->name('admin.settings.edit_profile');
  Route::post('/settings/store', "Admin\SettingController@store")->name('admin.settings.store');
  Route::post('/settings/update', "Admin\SettingController@update")->name('admin.settings.update');
  Route::get('/settings/ajax', "Admin\SettingController@ajax")->name('admin.settings.ajax');
  Route::post('/settings/delete', "Admin\SettingController@delete")->name('admin.settings.delete');
});
