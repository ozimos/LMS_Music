<?php

namespace Tests\Failure;

use App\User;
use App\Models\Profile;
use Tests\ControllerTestCase;

class ProfileFailTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/profiles';

    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true
        ]);
        $adminUser = factory(User::class)->create([
            'isAdmin' => true,
            'isArtiste' => true
        ]);

        $this->artisteUser = $artisteUser;
        $this->adminUser = $adminUser;
    }

    /** 
     * @test
     */
    function user_try_to_update_not_own_profile()
    {
        $oldProfile = factory(Profile::class)->create([
            'user_id' => $this->user->id
        ]);
        $newInput = [
            'content' => 'Updated test profile',
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$oldProfile->id}", $newInput);

        // Assert
        $response->assertStatus(403);
        $response->assertJsonFragment(['error' => 'UnAuthorized']);
    }

    /** 
     * @test
     */
    function admin_artiste_try_to_update_not_own_profile()
    {
        $oldProfile = factory(Profile::class)->create([
            'user_id' => $this->user->id
        ]);
        $newInput = [
            'content' => 'Updated test profile',
        ];
        $this->actingAs($this->adminUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$oldProfile->id}", $newInput);

        // Assert
        $response->assertStatus(403);
        $response->assertJsonFragment(['error' => 'UnAuthorized']);
    }

    /** 
     * @test
     */
    function user_try_to_delete_not_own_profile()
    {
        $profile = factory(Profile::class)->create([
            'user_id' => $this->user->id
        ]);
        $profileId = $profile->id;
        $this->actingAs($this->artisteUser, 'api');
        // Act
        $deleteResponse = $this->json('DELETE', "{$this->endpoint}/{$profileId}");
        $getResponse = $this->get("{$this->endpoint}/{$profileId}");
        // Assert
        $deleteResponse->assertStatus(403);
        $deleteResponse->assertJsonFragment(['error' => 'UnAuthorized']);

        $getResponse->assertStatus(200);
    }
}
