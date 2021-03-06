<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\ControllerTestCase;

class UserTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/users';

    public function setUp(): void
    {
        parent::setUp();
        $adminUser = factory(User::class)->create([
            'isAdmin' => true,
        ]);
        $this->actingAs($adminUser, 'api');
    }

    /** @test */
    public function admin_can_get_user_list()
    {
        // Act
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('GET', $this->endpoint);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                ['id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name, ],
                ],
        ]);
    }

    /** @test */
    public function admin_can_get_user_by_id()
    {
        // Act
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('GET', "{$this->endpoint}/{$this->user->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name,
                ],
        ]);
    }

    /** @test */
    public function user_can_update_user_by_id()
    {
        $this->actingAs($this->user, 'api');
        $updatedName = ['name' => 'random'];

        // Act
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$this->user->id}", $updatedName);

        // Assert
        // $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $updatedName['name'],
                ],
        ]);
    }

    /** @test */
    public function user_can_get_user_by_id()
    {
        // Act
        $this->actingAs($this->user, 'api');
        $response = $this->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('GET', "{$this->endpoint}/{$this->user->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
            'id' => $this->user->id,
            'email' => $this->user->email,
            'name' => $this->user->name,
            ],
            ]);
    }
}
