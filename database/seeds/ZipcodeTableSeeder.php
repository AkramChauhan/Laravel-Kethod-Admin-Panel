<?php

use Illuminate\Database\Seeder;

class ZipcodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $handle = fopen(asset("assets/csv_files/zipcodes.csv"), "r");
        $header = true;
        // $json = file_get_contents(asset("assets/jsons/zipcodes.json"));
        // $data = json_decode($json);

        while ($csvLine = fgetcsv($handle, 1000, ",")) {

            if ($header) {
                $header = false;
            } else {
                if($csvLine[8]==''){
                    $population = null;
                }else{
                    $population = (int)$csvLine[8];
                }
                DB::table('zipcodes')->insert(array(
                    'zipcode'=>$csvLine[0],
                    'latitude'=>$csvLine[1],
                    'longitude'=>$csvLine[2],
                    'city'=>$csvLine[3],
                    'state'=>$csvLine[4],
                    'state_fullname'=>$csvLine[5],
                    'population'=>$population,
                    'county'=>$csvLine[11],
                    'timezone'=>$csvLine[17],
                ));
            }
        }
    }
}
