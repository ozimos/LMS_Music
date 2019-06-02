<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\ControllerTestCase;

class AuthTest extends ControllerTestCase
{
    
    private $endpoint = 'api/v1/auth';
    

    /** @test */
    function new_user_can_register()
    {
        $user = factory(User::class)->make();

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            
        ])->json('POST', "{$this->endpoint}/register", [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'this_password_is_longer_than_15_characters',
            'password_confirmation' => 'this_password_is_longer_than_15_characters',
        ]);

        // Assert
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'meta' => ['token'],
            'data' => ['id', 'name', 'email']
            ]);
    }
    /** @test */
    function new_user_can_login()
    {
        $user = factory(User::class)->create();

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', "{$this->endpoint}/login", [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['token'],
            'data' => ['id', 'name', 'email']
            ]);
    }
    /** @test */
    function user_can_logout()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('GET', "{$this->endpoint}/logout");

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged out Successfully']);
    }
    /** @test */
    function user_can_be_got()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('GET', "{$this->endpoint}/user");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name,
                ]
            ]);
    }
    /** @test */
    function user_can_refresh_token()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('GET', "{$this->endpoint}/refresh");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['token'],
            ]);
    }
}
