<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleSchema extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'module_id',
        'col_name',
        'col_type',
        'col_length',
        'is_nullable',
        'is_index',
    ];

    public function module() {
        return $this->belongsTo(Module::class);
    }
}
