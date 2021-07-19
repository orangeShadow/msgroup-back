<?php

namespace Database\Factories;

use App\Models\malfunction_spare;
use App\Models\MalfunctionSpare;
use Illuminate\Database\Eloquent\Factories\Factory;

class MalfunctionSpareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MalfunctionSpare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'malfunction_id' => $this->faker->numberBetween(1,20),
            'spare_id' => $this->faker->numberBetween(1,300),
        ];
    }
}
