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
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', "{$this->endpoint}/register", [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        // Assert
        // $response->assertStatus(201);
        $response->assertJson(['status' => 'success']);
        $response->assertHeader('Authorization');
    }
    /** @test */
    function new_user_can_login()
    {
        $user = factory(User::class)->create();

        // Act
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', "{$this->endpoint}/login", [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertHeader('Authorization');
    }
    /** @test */
    function user_can_logout()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('POST', "{$this->endpoint}/logout");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
            ]);
    }
    /** @test */
    function user_can_be_got()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('GET', "{$this->endpoint}/user");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => $this->user->toArray()
            ]);
    }
    /** @test */
    function user_can_refresh_token()
    {
        $header = static::getHeaders($this->user);
        $defaultHeader = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        // Act
        $response = $this->withHeaders(array_merge($defaultHeader, $header))
            ->json('GET', "{$this->endpoint}/refresh");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            ]);
    }
}
