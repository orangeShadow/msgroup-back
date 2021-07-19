<?php

namespace Database\Factories;

use App\Models\malfunction;
use Illuminate\Database\Eloquent\Factories\Factory;

class MalfunctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = malfunction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Неиспр. '.$this->faker->word,
            'hours' => $this->faker->numberBetween(1,25),
            'price' => $this->faker->numberBetween(100,5000),
            'active' => $this->faker->boolean,
        ];
    }
}
