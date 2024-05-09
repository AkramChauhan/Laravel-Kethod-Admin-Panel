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
        Artisan::call('make:module ' . $module_name);
        Artisan::call('route:cache');
        return redirect()->to(route('admin.module.index'))->with('success', 'New module has been created.');
    }
}
