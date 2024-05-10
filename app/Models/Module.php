<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_singular',
        'model_name',
        'controller_name',
        'run_migration',
    ];

    public function module_schemas() {
        return $this->hasMany(ModuleSchema::class);
    }
}
