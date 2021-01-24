<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name',60)->nullable();
            $table->string('topLevelDomain',10)->nullable();
            $table->string('alpha2Code',10)->nullable();
            $table->string('alpha3Code',10)->nullable();
            $table->string('callingCodes',80)->nullable();
            $table->string('capital',60)->nullable();
            $table->string('region',60)->nullable();
            $table->string('subregion',60)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('demonym',60)->nullable();
            $table->bigInteger('area')->nullable();
            $table->float('gini')->nullable();
            $table->string('timezones')->nullable();
            $table->string('nativeName',100)->nullable();
            $table->integer('numericCode')->nullable();
            $table->string('currencies_code',40)->nullable();
            $table->string('currencies_name',80)->nullable();
            $table->string('currencies_symbol',10)->nullable();
            $table->string('flag')->nullable();
            $table->string('cioc',30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
