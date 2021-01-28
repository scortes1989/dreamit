<?php

namespace Tests\Feature\Api;

use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    function test_list_buildings()
    {
        $this->signIn();

        $building = Building::factory()->create();

        $this->get('api/v1/buildings')
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    0   => [
                        'id'    => $building->id,
                    ]
                ]
            ]);
    }

    function test_show_a_building()
    {
        $this->signIn();

        $building = Building::factory()->create();

        $this->get('api/v1/buildings/'.$building->id)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'name'  => $building->name,
                ]
            ]);
    }

    function test_store_a_building()
    {
        $this->signIn();

        $data = Building::factory()->make();

        $parameters = [
            'name'      => $data->name,
            'address'   => $data->address,
        ];

        $this->post('api/v1/buildings', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data'  => [
                    'name'  => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('buildings', [
            'name'      => $data->name,
            'address'   => $data->address,
        ]);
    }

    function test_validate_building_at_store()
    {
        $this->signIn();

        $this->postJson('api/v1/buildings', [])
            ->assertStatus(422)
            ->assertJson([
                'errors'  => [
                    'name'      => ['El campo Nombre es obligatorio.'],
                    'address'   => ['El campo Dirección es obligatorio.']
                ]
            ]);
    }

    function test_update_a_building()
    {
        $this->signIn();

        $building = Building::factory()->create();
        $data = Building::factory()->make();

        $parameters = [
            'name'      => $data->name,
            'address'   => $data->address,
        ];

        $this->put('api/v1/buildings/'.$building->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'id'  => $building->id,
                ]
            ]);

        $this->assertDatabaseHas('buildings', [
            'id'        => $building->id,
            'name'      => $data->name,
            'address'   => $data->address,
        ]);
    }

    function test_validate_building_at_update()
    {
        $this->signIn();

        $building = Building::factory()->create();

        $this->putJson('api/v1/buildings/'.$building->id, [])
            ->assertStatus(422)
            ->assertJson([
                'errors'  => [
                    'name'      => ['El campo Nombre es obligatorio.'],
                    'address'   => ['El campo Dirección es obligatorio.']
                ]
            ]);
    }

    function test_destroy_a_building()
    {
        $this->signIn();

        $building = Building::factory()->create();

        $this->delete('api/v1/buildings/'.$building->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('buildings', [
            'id'    => $building->id,
        ]);
    }
}
