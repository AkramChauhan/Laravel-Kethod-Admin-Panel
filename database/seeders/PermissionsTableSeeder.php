<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('permissions')->delete();
        
        DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'user-list',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user-update',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'user-add',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'role-list',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'role-update',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'role-add',
                'guard_name' => 'web',
                'created_at' => '2023-05-25 14:04:28',
                'updated_at' => '2023-05-25 14:04:28',
            ),
        ));
        
        
    }
}