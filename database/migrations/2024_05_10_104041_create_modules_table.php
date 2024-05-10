<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_singular');
            $table->string('model_name');
            $table->string('controller_name');
            $table->tinyInteger('run_migration')->default(0);
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
        Schema::dropIfExists('modules');
    }
}
