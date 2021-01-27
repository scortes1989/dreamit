<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function signIn($data = [])
    {
        $user = User::factory()->create($data);

        Passport::actingAs($user);

        return $user;
    }
}
