<?php

namespace Tests\Failure;

use Tests\ControllerTestCase;

class AuthFailTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/auth';


    /** 
     * @test
     */
    function user_try_to_log_in_with_wrong_credentials()
    {
        $credentials = ['email' => 999999,
        'password' => 'stringid'];

        // Act
        $response = $this->post("{$this->endpoint}/login", $credentials);
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'email' => ["Sorry we couldn't sign you in with those details."]
                ]
            ]);
    }

    /** 
     * @test
     */
    function user_try_to_register_with_field_not_validating()
    {
        $credentials = ['email' => 999999,
        'password' => 'stringid'];

        // Act
        $response = $this->post("{$this->endpoint}/register", $credentials);
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "status" => "error",
            'errors' => [
                'email' => [
                    "The email must be a string.",
                    "The email must be a valid email address."
                    ],
                "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    /** 
     * @test
     */
    function user_try_to_refresh_token_with_invalid_token()
    {
        $invalidToken = ['Authorization' => 'Bearer wrong_token'];

        // Act
        $response = $this->withHeaders($invalidToken)->get("{$this->endpoint}/refresh");
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'error' => 'refresh_token_error'
            ]);
    }
}
