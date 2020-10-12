<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => implode(" ", $this->faker->words(rand(1,3))),
            'status' => 1,
            'short_description' => $this->faker->text,
            'email_description' => $this->faker->text,
            'from' => $this->faker->email,
        ];
    }
}
