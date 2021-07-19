<?php

namespace Database\Factories;

use App\Models\user_malfunction;
use App\Models\UserMalfunction;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserMalfunctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserMalfunction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(5,19),
            'malfunction_id' => $this->faker->numberBetween(1,20),
        ];
    }
}
