<?php

namespace Database\Factories;

use App\Models\deal_spare;
use App\Models\DealSpare;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealSpareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DealSpare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deal_id' => $this->faker->numberBetween(1,100),
            'spare_id' => $this->faker->numberBetween(1,300),
            'title' => 'З. '.$this->faker->word,
            'price' => $this->faker->numberBetween(100,5000),
        ];
    }
}
