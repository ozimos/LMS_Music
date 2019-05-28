<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\ControllerTestCase;

class RegisterTest extends ControllerTestCase
{
    
    private $endpoint = 'api/v1/register';
    

    /** @test */
    function new_user_can_register()
    {
        $user = factory(User::class)->make();

        // Act
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', "/{$this->endpoint}", [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
}
