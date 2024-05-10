<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSchemasTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('module_schemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained();
            $table->string('col_name');
            $table->string('col_type');
            $table->integer('col_length');
            $table->tinyInteger('is_nullable');
            $table->tinyInteger('is_index');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('module_schemas');
    }
}
