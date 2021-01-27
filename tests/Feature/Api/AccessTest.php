<?php

namespace Tests\Feature\Api;

use App\Models\Access;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    function test_list_access_by_building()
    {
        $this->signIn();

        $building = Building::factory()->create();
        $access = Access::factory()->create(['building_id' => $building->id]);

        $this->get('api/v1/buildings/'.$building->id.'/accesses')
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    0   => [
                        'id'    => $access->id,
                        'user'  => [],
                    ]
                ]
            ]);
    }

    function test_list_access_by_user()
    {
        $user = $this->signIn();

        $access = Access::factory()->create(['user_id' => $user->id]);

        $this->get('api/v1/users/'.$user->id.'/accesses')
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    0   => [
                        'id'        => $access->id,
                        'building'  => [],
                    ]
                ]
            ]);
    }

    function test_store_a_enter_by_building()
    {
        $user = $this->signIn();

        $building = Building::factory()->create();

        $parameters = [
            'type'          => Access::ENTER,
            'building_id'   => $building->id,
        ];

        $this->post('api/v1/accesses', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('accesses', [
            'type'          => Access::ENTER,
            'user_id'       => $user->id,
            'building_id'   => $building->id,
        ]);
    }

    function test_store_a_leave_by_building()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $building = Building::factory()->create();

        $parameters = [
            'type'          => Access::LEAVE,
            'building_id'   => $building->id,
        ];

        $this->post('api/v1/accesses', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('accesses', [
            'type'          => Access::LEAVE,
            'user_id'       => $user->id,
            'building_id'   => $building->id,
        ]);
    }
}
