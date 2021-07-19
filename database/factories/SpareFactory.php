<?php

namespace Database\Factories;

use App\Models\spare;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = spare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Запч. '.$this->faker->word,
            'price' => $this->faker->numberBetween(100,5000),
        ];
    }
}
