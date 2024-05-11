<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SettingFactory extends Factory {
    protected $model = Setting::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'key' => Str::random(30),
            'value' => Str::random(100),
        ];
    }
}
