<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    protected $fillable = [
      'zipcode',
      'city',
      'state',
      'state_fullname',
      'population',
      'county',
      'latitude',
      'longitude',
      'timezone'
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
