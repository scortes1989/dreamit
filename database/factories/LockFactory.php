<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Lock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => User::factory()->create()->id,
            'building_id'   => Building::factory()->create()->id,
        ];
    }
}
