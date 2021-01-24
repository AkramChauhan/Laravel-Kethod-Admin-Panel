<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'topLevelDomain',
        'alpha2Code',
        'alpha3Code',
        'callingCodes',
        'capital',
        'region',
        'subregion',
        'population',
        'demonym',
        'area',
        'gini',
        'timezones',
        'nativeName',
        'numericCode',
        'currencies_code',
        'currencies_name',
        'currencies_symbol',
        'flag',
        'cioc',
    ];
    public static function createRecord($obj)
    {
        return self::create($obj);
    }

    public static function updateRecord($obj, $id)
    {
        return self::where('id', '=', $id)->update($obj);
    }
}
