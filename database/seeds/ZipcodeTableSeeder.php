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
        $ii = 0;
        while ($csvLine = fgetcsv($handle, 1000, ",")) {
            $ii++;
            if ($header) {
                $header = false;
            } else {
                $zipcode = $csvLine[0];
                $latitude = $csvLine[1];
                $longitude = $csvLine[2];
                $city_name = $csvLine[3];
                $state_code = $csvLine[4];
                $population = $csvLine[5];
                $county = $csvLine[6];

                if(empty($population)){
                    $population = null;
                }else{
                    $population = $population;
                }

                $stateObj = DB::table('states')->where('code',$state_code)->first();
                $state_id = $stateObj->id;

                $citObj = DB::table('cities')->where([
                    'name'=>$csvLine[3],
                    'state_id'=>$state_id
                ])->first();
                $city_id = $citObj->id;
                
                $exist_zip  = DB::table('zipcodes')->where([
                    'zipcode'=>$zipcode
                ])->count();
                $zipcode_insert = array(
                    'zipcode'=>$zipcode,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'city_id'=>$city_id,
                    'state_id'=>$state_id,
                    'population'=>$population,
                    'county'=>$county
                );
                if($exist_zip==0){
                    DB::table('zipcodes')->insert($zipcode_insert);
                }
            }
        }
        echo $ii;
    }
}
