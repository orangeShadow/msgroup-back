<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deal_id' => $this->faker->numberBetween(1,100),
            'user_id' => $this->faker->numberBetween(20,30),
            'command' => $this->faker->boolean,
            'message' => $this->faker->sentence,
            'dt' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
