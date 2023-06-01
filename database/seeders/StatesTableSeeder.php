<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('states')->delete();
        
        DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Puerto Rico',
                'code' => 'PR',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Virgin Islands',
                'code' => 'VI',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Massachusetts',
                'code' => 'MA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Rhode Island',
                'code' => 'RI',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'New Hampshire',
                'code' => 'NH',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Maine',
                'code' => 'ME',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Vermont',
                'code' => 'VT',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Connecticut',
                'code' => 'CT',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'New York',
                'code' => 'NY',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'New Jersey',
                'code' => 'NJ',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Pennsylvania',
                'code' => 'PA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Delaware',
                'code' => 'DE',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'District of Columbia',
                'code' => 'DC',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Virginia',
                'code' => 'VA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Maryland',
                'code' => 'MD',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'West Virginia',
                'code' => 'WV',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'North Carolina',
                'code' => 'NC',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'South Carolina',
                'code' => 'SC',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Georgia',
                'code' => 'GA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Florida',
                'code' => 'FL',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Alabama',
                'code' => 'AL',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Tennessee',
                'code' => 'TN',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Mississippi',
                'code' => 'MS',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Kentucky',
                'code' => 'KY',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Ohio',
                'code' => 'OH',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Indiana',
                'code' => 'IN',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Michigan',
                'code' => 'MI',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Iowa',
                'code' => 'IA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Wisconsin',
                'code' => 'WI',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Minnesota',
                'code' => 'MN',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'South Dakota',
                'code' => 'SD',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'North Dakota',
                'code' => 'ND',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Montana',
                'code' => 'MT',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Illinois',
                'code' => 'IL',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Missouri',
                'code' => 'MO',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Kansas',
                'code' => 'KS',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Nebraska',
                'code' => 'NE',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Louisiana',
                'code' => 'LA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Arkansas',
                'code' => 'AR',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Oklahoma',
                'code' => 'OK',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Texas',
                'code' => 'TX',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Colorado',
                'code' => 'CO',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Wyoming',
                'code' => 'WY',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Idaho',
                'code' => 'ID',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Utah',
                'code' => 'UT',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Arizona',
                'code' => 'AZ',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'New Mexico',
                'code' => 'NM',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Nevada',
                'code' => 'NV',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'California',
                'code' => 'CA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Hawaii',
                'code' => 'HI',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'American Samoa',
                'code' => 'AS',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Guam',
                'code' => 'GU',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Northern Mariana Islands',
                'code' => 'MP',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Oregon',
                'code' => 'OR',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Washington',
                'code' => 'WA',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Alaska',
                'code' => 'AK',
                'country_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}