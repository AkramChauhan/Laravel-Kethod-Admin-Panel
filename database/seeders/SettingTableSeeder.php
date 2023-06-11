<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    DB::table('settings')->insert([
      'key' => "SITE_NAME",
      'value' => config('app.name'),
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now()
    ]);
    DB::table('settings')->insert([
      'key' => "SITE_URL",
      'value' => config('app.url'),
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now()
    ]);
    DB::table('settings')->insert([
      'key' => "TAGLINE",
      'value' => "Awesome tabline for your panel",
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now()
    ]);
  }
}
