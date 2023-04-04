<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name'=>"Administrator",
            'email'=>"admin@gmail.com",
            'password'=>bcrypt('password'),
            'two_factor_enable'=>false,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('users')->insert([
            'name'=>"New User",
            'email'=>"new_user@gmail.com",
            'password'=>bcrypt('password'),
            'two_factor_enable'=>false,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
