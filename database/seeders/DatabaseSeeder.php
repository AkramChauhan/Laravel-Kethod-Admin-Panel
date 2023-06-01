<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  /**
   * Seeder the application's database.
   *
   * @return void
   */
  public function run() {
    $this->call(UserTableSeeder::class);
    $this->call(RoleTableSeeder::class);
    $this->call(SettingTableSeeder::class);
    $this->call(PermissionsTableSeeder::class);
    $this->call(RoleHasPermissionsTableSeeder::class);
    $this->call(ModelHasRoleTableSeeder::class);
    $this->call(CountriesTableSeeder::class);
    $this->call(StatesTableSeeder::class);
    $this->call(CitiesTableSeeder::class);
    $this->call(ZipcodesTableSeeder::class);
  }
}
