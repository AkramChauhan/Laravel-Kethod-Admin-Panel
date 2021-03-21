<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createRecord($obj)
    {
        return self::create($obj);
    }

    public static function updateRecord($obj, $id)
    {
        return self::where('id', '=', $id)->updateOrCreate($obj);
    }
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public function isAdmin() {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function getRoleIdAttribute() {
        $roles = $this->roles;
        // $role =  $this->roles()->first();
        // dd($role);
        // print_r($role);exit;
        return $roles->isEmpty() ? '0' :$roles->first()->id;
    }
    public function getRoleAttribute() {
        $roles = $this->roles;
        // $role =  $this->roles()->first();
        // dd($role);
        // print_r($role);exit;
        return $roles->isEmpty() ? 'User' :$roles->first()->name;
    }
}
