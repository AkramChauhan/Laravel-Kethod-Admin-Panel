<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'content',
    ];

    public function getEncryptedIdAttribute() {
        $id = Crypt::encryptString($this->id);
        return $id;
    }
    public function getShowRouteAttribute() {
        $e_id = Crypt::encryptString($this->id);
        $route = route('admin.pages.show', ['encrypted_id' => $e_id]);
        return $route;
    }
    public function getEditRouteAttribute() {
        $e_id = Crypt::encryptString($this->id);
        $route = route('admin.pages.edit', ['encrypted_id' => $e_id]);
        return $route;
    }
    public function getIndexRouteAttribute() {
        $route = route('admin.pages.index');
        return $route;
    }
}