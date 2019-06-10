<?php

namespace Tests\Feature\Api;

use App\User;
use App\Models\Profile;
use Tests\ControllerTestCase;

class ProfilesTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/profiles';

    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true,
        ]);
        $adminUser = factory(User::class)->create([
            'isAdmin' => true,
        ]);
        $this->artisteUser = $artisteUser;
        $this->adminUser = $adminUser;
    }

    /** @test */
    public function user_can_view_all_profiles()
    {
        $profile = factory(Profile::class)->create([
            'user_id' => $this->user->id,
            ]);

        // Act
        $response = $this->get($this->endpoint);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $profile->content,
            'user_id' => $profile->user_id,
        ]);
    }

    /** @test */
    public function user_can_view_a_single_profile()
    {
        $profile = factory(Profile::class)->create([
            'user_id' => $this->user->id,
        ]);

        // Act
        $response = $this->get("{$this->endpoint}/{$profile->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $profile->content,
            'user_id' => $profile->user_id,
        ]);
    }

    /** @test */
    public function artiste_can_create_a_single_profile()
    {
        $input = [
            'content' => 'some content',
            'random' => 'some random',
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', $this->endpoint, $input);

        // Assert
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'content' => $input['content'],
            'user_id' => $this->artisteUser->id,
        ]);
    }

    /** @test */
    public function artiste_can_update_a_single_profile()
    {
        $oldProfile = factory(Profile::class)->create([
            'user_id' => $this->artisteUser->id,
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
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $newInput['content'],
            'user_id' => $oldProfile->user_id,
        ]);
    }

    /** @test */
    public function artiste_can_delete_a_single_profile()
    {
        $profile = factory(Profile::class)->create([
            'user_id' => $this->artisteUser->id,
        ]);
        $profileId = $profile->id;

        $this->actingAs($this->artisteUser, 'api');

        // Act
        $deleteResponse = $this->json('DELETE', "{$this->endpoint}/{$profileId}");
        $getResponse = $this->get("{$this->endpoint}/{$profileId}");

        // Assert
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
            ]);

        $getResponse->assertStatus(404);
    }

    /** @test */
    public function admin_can_delete_an_artistes_single_profile()
    {
        $profile = factory(Profile::class)->create([
            'user_id' => $this->artisteUser->id,
        ]);
        $profileId = $profile->id;

        $this->actingAs($this->adminUser, 'api');

        // Act
        $deleteResponse = $this->json('DELETE', "{$this->endpoint}/{$profileId}");
        $getResponse = $this->get("{$this->endpoint}/{$profileId}");

        // Assert
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
            ]);

        $getResponse->assertStatus(404);
    }
}
