<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = "assets/json_files/countries.json";
        $json = public_path($path);
        $json = file_get_contents($json);
        $data = json_decode($json);
        foreach ($data as $obj) {

            $currencies_code = $obj->currencies[0]->code;
            $currencies_name = $obj->currencies[0]->name;
            $currencies_symbol = $obj->currencies[0]->symbol;
            $topLevelDomain = $obj->topLevelDomain[0];
            $callingCodes = json_encode($obj->callingCodes);
            
            DB::table('countries')->insert(array(
                'name'=>$obj->name,
                'topLevelDomain'=>$topLevelDomain,
                'alpha2Code'=>$obj->alpha2Code,
                'alpha3Code'=>$obj->alpha3Code,
                'callingCodes'=>$callingCodes,
                'capital'=>$obj->capital,
                'region'=>$obj->region,
                'subregion'=>$obj->subregion,
                'population'=>$obj->population,
                'demonym'=>$obj->demonym,
                'area'=>$obj->area,
                'gini'=>$obj->gini,
                'timezones'=>json_encode($obj->timezones),
                'nativeName'=>$obj->nativeName,
                'numericCode'=>$obj->numericCode,
                'currencies_code'=>$currencies_code,
                'currencies_name'=>$currencies_name,
                'currencies_symbol'=>$currencies_symbol,
                'flag'=>$obj->flag,
                'cioc'=>$obj->cioc,
            ));
        }
    }
}
