<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    function test_list_users()
    {
        $user = $this->signIn();

        $this->get('api/v1/users')
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    0   => [
                        'id'    => $user->id,
                    ]
                ]
            ]);
    }

    function test_show_a_user()
    {
        $this->signIn();

        $user = User::factory()->create();

        $this->get('api/v1/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'id'    => $user->id,
                ]
            ]);
    }

    function test_store_a_user()
    {
        $this->signIn();

        $data = User::factory()->make();

        $parameters = [
            'name'      => $data->name,
            'email'     => $data->email,
            'password'  => 123456,
        ];

        $this->post('api/v1/users', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data'  => [
                    'name'  => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name'      => $data->name,
            'email'     => $data->email,
        ]);
    }

    function test_update_a_user()
    {
        $this->signIn();

        $user = User::factory()->create();
        $data = User::factory()->make();

        $parameters = [
            'name'      => $data->name,
            'email'     => $data->email,
            'password'  => 123456,
        ];

        $this->put('api/v1/users/'.$user->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'id'  => $user->id,
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'name'      => $data->name,
            'email'     => $data->email,
        ]);
    }

    function test_delete_a_user()
    {
        $this->signIn();

        $user = User::factory()->create();

        $this->delete('api/v1/users/'.$user->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('users', [
            'id'    => $user->id,
        ]);
    }
}
