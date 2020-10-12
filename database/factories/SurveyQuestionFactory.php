<?php

namespace Database\Factories;

use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SurveyQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ["Text", "Textarea", "Checkbox", "Radio"];
        return [
            "order" => $this->faker->unique(true, 100000)->numberBetween(1,49),
            "type" => $types[array_rand($types)],
            "question" => $this->faker->sentence(rand(6, 15)),
            "options" => implode(",", $this->faker->words(rand(2, 4))),
            "required" => $this->faker->boolean(50),
        ];
    }
}
