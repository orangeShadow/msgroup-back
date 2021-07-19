<?php

namespace Database\Factories;

use App\Models\fcm;
use Illuminate\Database\Eloquent\Factories\Factory;

class FcmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = fcm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,30),
            'token' => $this->faker->uuid,
        ];
    }
}
