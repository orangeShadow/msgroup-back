<?php

namespace Database\Factories;

use App\Models\push;
use Illuminate\Database\Eloquent\Factories\Factory;

class PushFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = push::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,30),
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->sentence,
            'page_id' => $this->faker->numberBetween(0,3),
            'param_id' => $this->faker->numberBetween(1,1000),
        ];
    }
}
