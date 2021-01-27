<?php

namespace Tests\Feature\Api;

use App\Models\Building;
use App\Models\Lock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockTest extends TestCase
{
    use RefreshDatabase;

    function test_list_locks()
    {
        $this->signIn();

        $lock = Lock::factory()->create();

        $this->get('api/v1/locks')
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    0   => [
                        'id'        => $lock->id,
                        'user'      => [],
                        'building'  => [],
                    ]
                ]
            ]);
    }

    function test_lock_a_user()
    {
        $this->signIn();

        $user = User::factory()->create();
        $building = Building::factory()->create();

        $parameters = [
            'building_id'   => $building->id,
            'user_id'       => $user->id,
        ];

        $this->post('api/v1/locks', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('locks', [
            'building_id'   => $building->id,
            'user_id'       => $user->id,
        ]);
    }

    function test_unlock_a_user()
    {
        $this->signIn();

        $lock = Lock::factory()->create();

        $this->delete('api/v1/locks/'.$lock->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('locks', [
            'id'    => $lock->id,
        ]);
    }
}
