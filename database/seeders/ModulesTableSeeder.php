<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('modules')->delete();
        
        DB::table('modules')->insert(array (
            0 => 
            array (
                'controller_name' => 'PageController',
                'created_at' => '2024-05-11 15:20:29',
                'deleted_at' => NULL,
                'id' => 1,
                'model_name' => 'Page',
                'name' => 'pages',
                'name_singular' => 'page',
                'run_migration' => 0,
                'updated_at' => '2024-05-11 15:20:29',
            ),
        ));
        
        
    }
}