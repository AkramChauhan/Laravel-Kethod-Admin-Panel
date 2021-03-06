<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Preparing count for Dashboard Array
        $users = User::count();
        $roles = Role::count();

        // Preparing Dashboard card Array.
        $dashboard_cards = [
            ['Users', $users, Route('admin.users.index'),'fa fa-dashboard'],
            ['Roles', $roles, Route('admin.roles.index'),'fa fa-sitemap'],
            // ['News', $news, 'news.index'],
        ];
        return kview('home',compact('dashboard_cards'));
    }
}
