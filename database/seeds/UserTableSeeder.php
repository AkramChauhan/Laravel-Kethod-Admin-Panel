<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('users')->insert([
            'name'=>"Administrator",
            'email'=>"admin@gmail.com",
            'password'=>bcrypt('password'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('users')->insert([
            'name'=>"New User",
            'email'=>"new_user@gmail.com",
            'password'=>bcrypt('password'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
