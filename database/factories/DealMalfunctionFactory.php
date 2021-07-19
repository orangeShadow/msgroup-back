<?php

namespace Database\Factories;

use App\Models\deal_malfunction;
use App\Models\DealMalfunction;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealMalfunctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DealMalfunction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deal_id' => $this->faker->numberBetween(1,100),
            'malfunction_id' => $this->faker->numberBetween(1,20),
            'title' => 'Н. '.$this->faker->word,
            'hours' => $this->faker->numberBetween(1,25),
            'price' => $this->faker->numberBetween(100,5000),
        ];
    }
}
