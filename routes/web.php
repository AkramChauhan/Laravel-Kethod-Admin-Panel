<?php

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

Route::get('/','IndexController@index')->name('home');

Auth::routes([
  'register' => true, // Registration Routes...
  'reset' => true, // Password Reset Routes...
  'verify' => true, // Email Verification Routes...
]);

Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {
  // For Users
    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::get('/users/add', "UserController@create")->name('admin.users.create');
    Route::get('/users/edit', "UserController@edit")->name('admin.users.edit');
    Route::post('/users/store', "UserController@store")->name('admin.users.store');
    Route::post('/users/update', "UserController@update")->name('admin.users.update');
    Route::get('/users/ajax', "UserController@ajax")->name('admin.users.ajax');
    Route::post('/users/delete', "UserController@delete")->name('admin.users.delete');

  // For Roles
    Route::get('/roles', 'RoleController@index')->name('admin.roles.index');
    Route::get('/roles/add', "RoleController@create")->name('admin.roles.create');
    Route::get('/roles/edit', "RoleController@edit")->name('admin.roles.edit');
    Route::post('/roles/store', "RoleController@store")->name('admin.roles.store');
    Route::post('/roles/update', "RoleController@update")->name('admin.roles.update');
    Route::get('/roles/ajax', "RoleController@ajax")->name('admin.roles.ajax');
    Route::post('/roles/delete', "RoleController@delete")->name('admin.roles.delete');
  
  // For Zipcodes
    Route::get('/zipcodes', 'ZipcodeController@index')->name('admin.zipcodes.index');
    Route::get('/zipcodes/add', "ZipcodeController@create")->name('admin.zipcodes.create');
    Route::get('/zipcodes/edit', "ZipcodeController@edit")->name('admin.zipcodes.edit');
    Route::post('/zipcodes/store', "ZipcodeController@store")->name('admin.zipcodes.store');
    Route::post('/zipcodes/update', "ZipcodeController@update")->name('admin.zipcodes.update');
    Route::get('/zipcodes/ajax', "ZipcodeController@ajax")->name('admin.zipcodes.ajax');
    Route::post('/zipcodes/delete', "ZipcodeController@delete")->name('admin.zipcodes.delete');

});
