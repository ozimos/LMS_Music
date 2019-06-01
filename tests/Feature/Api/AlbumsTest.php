<?php

namespace Tests\Feature\Api;

use App\Models\Album;
use App\User;
use Tests\ControllerTestCase;

class AlbumsTest extends ControllerTestCase
{
    
    private $endpoint = 'api/v1/albums';
    
    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true
        ]);
        $this->artisteUser = $artisteUser;
    }

    /** @test */
    function user_can_view_all_albums()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->user->id
            ]);

        // Act
        $response = $this->get($this->endpoint);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $album->title,
            'user_id' => $album->user_id
        ]);
    }

    /** @test */
    function user_can_view_a_single_album()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->user->id
        ]);

        // Act
        $response = $this->get("{$this->endpoint}/{$album->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $album->title,
            'user_id' => $album->user_id
        ]);
    }

    /** @test */
    function user_can_create_a_single_album()
    {
        $input = [
            'title' => 'some title',
            'image' => 'some/random/url'
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', $this->endpoint, $input);

        // Assert
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'title' => $input['title'],
            'user_id' => $this->artisteUser->id
        ]);
    }

    /** @test */
    function user_can_update_a_single_album()
    {
        $oldAlbum = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $newInput = [
            'title' => 'Updated test album',
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$oldAlbum->id}", $newInput);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $newInput['title'],
            'user_id' => $oldAlbum->user_id
        ]);
    }

    /** @test */
    function user_can_delete_a_single_album()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->user->id
        ]);
        $albumId = $album->id;
        
        // Act
        $deleteResponse = $this->json('DELETE', "{$this->endpoint}/{$albumId}");
        $getResponse = $this->get("{$this->endpoint}/{$albumId}");

        // Assert
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
            ]);

        $getResponse->assertStatus(404);
    }
}
