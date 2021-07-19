<?php

namespace Database\Factories;

use App\Models\deal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = deal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $man = $this->faker->numberBetween(1,5);
        return [
            'client_id' => $this->faker->numberBetween(20,30),
            'manufacturer_id' => $man,
            'device_id' => $man * 10 + $this->faker->numberBetween(0,9),
            'serial' => $this->faker->uuid(),
            'password' => $this->faker->word,
            'dev_id' => $this->faker->ean13(),
            'dev_id_password' => $this->faker->word,
            'completeness' => $this->faker->sentence,
            'condition_id' => $this->faker->numberBetween(1,9),
            'malfunction_id' => $this->faker->numberBetween(1,20),
            'point_a_id' => $this->faker->numberBetween(1,12),
            'point_b_id' => $this->faker->numberBetween(1,12),
            'master_id' => $this->faker->numberBetween(21,30),
            'video_acceptance' => $this->faker->url,
            'video_diagnostics' => $this->faker->url,
            'video_repair' => $this->faker->url,
            'client_mark' => $this->faker->numberBetween(1,5),
            'client_comment' => $this->faker->paragraph,
            'master_mark' => $this->faker->numberBetween(1,5),
            'master_comment' => $this->faker->paragraph,
            'delay_reason' => $this->faker->boolean? $this->faker->paragraph : '',
            'status' => $this->faker->numberBetween(0,10),
            'price' => $this->faker->numberBetween(1000,25000),
            'deleted' => false,
        ];
    }
}
