<?php

namespace Database\Factories;

use App\Models\KBGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class KBGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KBGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->sentence(2, true),
            "description" => $this->faker->paragraph(2, true),
            "order" => $this->faker->unique()->numberBetween(1,7),
            "draft" => $this->faker->boolean(50)
        ];
    }
}
