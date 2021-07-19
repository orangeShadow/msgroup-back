<?php

namespace Database\Factories;

use App\Models\condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = condition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Неиспр. '.$this->faker->word,
            'active' => $this->faker->boolean,
        ];
    }
}
