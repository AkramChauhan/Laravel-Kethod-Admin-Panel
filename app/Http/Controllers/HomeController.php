<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        // Preparing Dashboard card Array.
        $dashboard_cards = [
            ['Users', $users, Route('admin.users.index'),'fa fa-dashboard'],
            // ['News', $news, 'news.index'],
        ];
        return kview('home',compact('dashboard_cards'));
    }
}
