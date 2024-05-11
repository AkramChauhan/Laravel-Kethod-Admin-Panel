<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSchemasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('module_schemas')->delete();
        
        DB::table('module_schemas')->insert(array (
            0 => 
            array (
                'col_length' => 60,
                'col_name' => 'name',
                'col_type' => 'string',
                'created_at' => '2024-05-11 15:20:29',
                'deleted_at' => NULL,
                'id' => 1,
                'is_index' => 0,
                'is_nullable' => 1,
                'module_id' => 1,
                'updated_at' => '2024-05-11 15:20:29',
            ),
            1 => 
            array (
                'col_length' => 0,
                'col_name' => 'content',
                'col_type' => 'longText',
                'created_at' => '2024-05-11 15:20:29',
                'deleted_at' => NULL,
                'id' => 2,
                'is_index' => 0,
                'is_nullable' => 1,
                'module_id' => 1,
                'updated_at' => '2024-05-11 15:20:29',
            ),
        ));
        
        
    }
}