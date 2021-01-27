<?php

namespace Database\Factories;

use App\Models\Access;
use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Access::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'          => $this->faker->randomElement([Access::ENTER, Access::LEAVE]),
            'user_id'       => User::factory()->create()->id,
            'building_id'   => Building::factory()->create()->id,
        ];
    }
}
