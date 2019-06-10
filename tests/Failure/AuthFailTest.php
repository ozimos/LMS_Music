<?php

namespace Tests\Failure;

use Tests\ControllerTestCase;

class AuthFailTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/auth';

    /**
     * @test
     */
    public function user_try_to_log_in_with_wrong_credentials()
    {
        $credentials = ['email' => 999999,
        'password' => 'stringid', ];

        // Act
        $response = $this->json('POST', "{$this->endpoint}/login", $credentials);
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'email' => ["Sorry we couldn't sign you in with those details."],
                ],
            ]);
    }

    /**
     * @test
     */
    public function user_try_to_register_with_field_not_validating()
    {
        $credentials = ['email' => 999999,
        'password' => 999999, ];

        // Act
        $response = $this->json('POST', "{$this->endpoint}/register", $credentials);
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'email' => [
                    'The email must be a string.',
                    'The email must be a valid email address.',
                    ],
                'password' => [
                    'The password confirmation does not match.',
                    'The password must be a string.',
                    'The password must be at least 8 characters.',
                    'The password must contain at least one integer or be at least 15 characters long',
                    'The password must contain at least one lowercase English letter or be at least 15 characters long',
                    'The password must contain at least one special character or be at least 15 characters long',
                    'The password must contain at least one uppercase English letter or be at least 15 characters long',
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function user_try_to_register_with_field_failing_validation()
    {
        $credentials = ['email' => 'assss',
        'password' => 'stringid', ];

        // Act
        $response = $this->json('POST', "{$this->endpoint}/register", $credentials);
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'email' => [
                    'The email must be a valid email address.',
                    ],
                'password' => [
                    'The password confirmation does not match.',
                    'The password must contain at least one integer or be at least 15 characters long',
                    'The password must contain at least one special character or be at least 15 characters long',
                    'The password must contain at least one uppercase English letter or be at least 15 characters long',
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function user_try_to_refresh_token_with_invalid_token()
    {
        $invalidTokenHeaders = [
            'Authorization' => 'Bearer wrong_token',
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // Act
        $response = $this->withHeaders($invalidTokenHeaders)->json('GET', "{$this->endpoint}/refresh");
        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'error' => 'refresh_token_error',
            ]);
    }
}
