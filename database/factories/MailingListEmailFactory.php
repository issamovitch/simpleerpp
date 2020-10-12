<?php

namespace Database\Factories;

use App\Models\MailingListEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailingListEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MailingListEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "email" => $this->faker->email
        ];
    }
}
