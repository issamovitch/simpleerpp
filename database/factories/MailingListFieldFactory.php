<?php

namespace Database\Factories;

use App\Models\MailingListField;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailingListFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MailingListField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => implode(" ", $this->faker->words(rand(1,3)))
        ];
    }
}
