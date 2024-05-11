<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable {
    use Notifiable, SoftDeletes, HasRoles, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'phone_number',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime',
    ];

    public static function createRecord($obj) {
        return self::create($obj);
    }

    public static function updateRecord($obj, $id) {
        return self::where('id', '=', $id)->updateOrCreate($obj);
    }

    public function generateTwoFactorCode() {
        $this->timestamps = false;
        $this->two_factor_code = rand(10000000, 99999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }
    public function getIsUserAttribute() {
        return $this->hasRole('User');
    }
    public function getIsAdminAttribute() {
        return $this->hasRole('Admin');
    }
    public function resetTwoFactorCode() {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
    public function getEncryptedIdAttribute() {
        $id = Crypt::encryptString($this->id);
        return $id;
    }
    public function getShowRouteAttribute() {
        $e_id = Crypt::encryptString($this->id);
        $route = route('admin.users.show', ['encrypted_id' => $e_id]);
        return $route;
    }
    public function getEditRouteAttribute() {
        $e_id = Crypt::encryptString($this->id);
        $route = route('admin.users.edit', ['encrypted_id' => $e_id]);
        return $route;
    }
    public function getIndexRouteAttribute() {
        $route = route('admin.users.index');
        return $route;
    }
}
