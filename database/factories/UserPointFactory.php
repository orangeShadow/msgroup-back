<?php

namespace Database\Factories;

use App\Models\UserPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'point_id' => $this->faker->numberBetween(10,12),
            'user_id' => $this->faker->numberBetween(10,30),
        ];
    }
}
