<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'name',
      'code'
    ];

    public function cities(){
        return $this->hasMany('App\Models\City');
    }

    public function zipcodes(){
        return $this->hasMany('App\Models\Zipcode');
    }
    
    public static function createRecord($obj)
    {
        return self::create($obj);
    }

    public static function updateRecord($obj, $id)
    {
        return self::where('id', '=', $id)->update($obj);
    }
}
