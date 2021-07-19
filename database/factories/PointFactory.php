<?php

namespace Database\Factories;

use App\Models\point;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = point::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->word,
            'hours' => 'пн-пт 10:00-18:00',
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->longitude,
//            'print_host' => $this->faker->ipv4,
//            'print_login' => $this->faker->userName,
//            'print_pass' => $this->faker->password,
        ];
    }
}
