<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'name_singular' => $this->faker->name(),
            'model_name' => $this->faker->name(),
            'controller_name' => $this->faker->name(),
            'run_migration' => $this->faker->numberBetween(0,1),
            'deleted_at' => null
        ];
    }
}
