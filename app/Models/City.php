<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
      'name',
      'state_id',
      'timezone'
    ];
    
    public function state(){
      return $this->belongsTo('App\Models\State');
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
