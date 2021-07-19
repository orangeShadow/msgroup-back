<?php

namespace Database\Factories;

use App\Models\fine;
use Illuminate\Database\Eloquent\Factories\Factory;

class FineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = fine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date1 = $this->faker->date();
        $date2 = date('Y-m-d', strtotime('+1 month', strtotime($date1)));
        return [
            'user_id' => $this->faker->numberBetween(10,19),
            'amount' => $this->faker->randomElement([0, 10, 20, 30]),
            'date_begin' => $date1,
            'date_end' => $date2,
        ];
    }
}
