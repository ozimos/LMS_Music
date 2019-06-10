<?php

namespace Tests\Feature\Api;

use App\User;
use App\Models\Song;
use App\Models\Album;
use Tests\ControllerTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AlbumsTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/albums';

    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true,
        ]);
        $this->artisteUser = $artisteUser;
        $adminUser = factory(User::class)->create([
            'isAdmin' => true,
        ]);
        $this->adminUser = $adminUser;
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id,
            ]);
        $this->album = $album;
    }

    /** @test */
    public function user_can_view_all_albums()
    {

        // Act
        $response = $this->get($this->endpoint);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $this->album->title,
            'user_id' => $this->album->user_id,
        ]);
    }

    /** @test */
    public function user_can_view_a_single_album()
    {

        // Act
        $response = $this->get("{$this->endpoint}/{$this->album->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $this->album->title,
            'user_id' => $this->album->user_id,
        ]);
    }

    /** @test */
    public function artiste_can_create_a_single_album()
    {
        $input = [
            'title' => 'some title',
            'image' => 'some/random/url',
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
            'user_id' => $this->artisteUser->id,
        ]);
    }

    /** @test */
    public function artiste_can_create_a_single_song()
    {
        $input = [
             'title' => 'some title',
             'description' => 'some/random/url',
         ];

        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
         ])->json('POST', "{$this->endpoint}/{$this->album->id}/songs", $input);

        // Assert
        $response->assertStatus(201);
        $response->assertJsonFragment([
             'title' => $input['title'],
             'album_id' => $this->album->id,
         ]);
    }

    /** @test */
    public function artiste_can_update_a_single_song()
    {
        $song = factory(Song::class)->create([
            'album_id' => $this->album->id,
        ]);

        $input = [
             'title' => 'new title',
             'description' => 'some/random/url',
         ];

        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('PUT',
                "{$this->endpoint}/{$this->album->id}/songs/{$song->id}", $input);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
             'title' => $input['title'],
             'description' => $input['description'],
             'album_id' => $this->album->id,
         ]);
    }

    /** @test */
    public function admin_can_delete_an_artistes_single_song()
    {
        $song = factory(Song::class)->create([
            'album_id' => $this->album->id,
        ]);

        $this->actingAs($this->adminUser, 'api');

        // Act
        $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('DELETE',
                "{$this->endpoint}/{$this->album->id}/songs/{$song->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
         ]);
    }

    /** @test */
    public function artiste_can_delete_a_single_song()
    {
        $song = factory(Song::class)->create([
            'album_id' => $this->album->id,
        ]);

        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('DELETE',
                "{$this->endpoint}/{$this->album->id}/songs/{$song->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
         ]);
    }

    /** @test */
    public function artiste_can_update_a_single_album()
    {
        $newInput = [
            'title' => 'Updated test album',
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$this->album->id}", $newInput);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $newInput['title'],
            'user_id' => $this->album->user_id,
        ]);
    }

    /** @test */
    public function artiste_can_upload_a_single_song()
    {
        $song = factory(Song::class)->create([
            'album_id' => $this->album->id,
        ]);

        $input = [
             'song' => UploadedFile::fake()->create('test.mp3', 2),
         ];

        $this->actingAs($this->artisteUser, 'api');

        Storage::fake('local');

        // Act
        $response = $this->json(
                'POST',
                "{$this->endpoint}/{$this->album->id}/songs/{$song->id}",
                $input
            );

        // Assert
        $path = $response->json('data.file');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' =>['album_id', 'file', 'title', 'release_date'],
            ]);
        $this->assertNotEquals($path, $song->file);
        Storage::disk('local')->assertExists($path);
    }

    /** @test */
    public function artiste_can_delete_a_single_album()
    {
        $albumId = $this->album->id;

        $this->actingAs($this->artisteUser, 'api');

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

    /** @test */
    public function admin_can_delete_an_artistes_single_album()
    {
        $albumId = $this->album->id;

        $this->actingAs($this->adminUser, 'api');

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
