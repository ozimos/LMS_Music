<?php

namespace Tests\Feature\Api;

use App\Models\Album;
use App\Models\Song;
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
        $adminUser = factory(User::class)->create([
            'isAdmin' => true
        ]);
        $this->artisteUser = $artisteUser;
        $this->adminUser = $adminUser;
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
    function artiste_can_create_a_single_album()
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
     function artiste_can_create_a_single_song()
     {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);

         $input = [
             'title' => 'some title',
             'file' => 'some/random/url'
         ];

         $this->actingAs($this->artisteUser, 'api');
 
         // Act
         $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
         ])->json('POST', "{$this->endpoint}/{$album->id}/songs", $input);
 
         // Assert
         $response->assertStatus(201);
         $response->assertJsonFragment([
             'title' => $input['title'],
             'album_id' => $album->id
         ]);
     }

     /** @test */
     function artiste_can_update_a_single_song()
     {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $song = factory(Song::class)->create([
            'album_id' => $album->id
        ]);

         $input = [
             'title' => 'new title',
             'file' => 'some/random/url'
         ];

         $this->actingAs($this->artisteUser, 'api');
 
         // Act
         $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('PUT',
                "{$this->endpoint}/{$album->id}/songs/{$song->id}", $input);
 
         // Assert
         $response->assertStatus(200);
         $response->assertJsonFragment([
             'title' => $input['title'],
             'file' => $input['file'],
             'album_id' => $album->id
         ]);
     }

     /** @test */
    function admin_can_delete_an_artistes_single_song()
     {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $song = factory(Song::class)->create([
            'album_id' => $album->id
        ]);


         $this->actingAs($this->adminUser, 'api');
 
         // Act
         $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('DELETE',
                "{$this->endpoint}/{$album->id}/songs/{$song->id}");
 
         // Assert
         $response->assertStatus(200);
         $response->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
         ]);
     }

     /** @test */
     function artiste_can_delete_a_single_song()
     {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $song = factory(Song::class)->create([
            'album_id' => $album->id
        ]);


         $this->actingAs($this->artisteUser, 'api');
 
         // Act
         $response = $this->withHeaders([
             'X-Requested-With' => 'XMLHttpRequest',
            ])->json('DELETE',
                "{$this->endpoint}/{$album->id}/songs/{$song->id}");
 
         // Assert
         $response->assertStatus(200);
         $response->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
         ]);
     }

    /** @test */
    function artiste_can_update_a_single_album()
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
    function artiste_can_delete_a_single_album()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $albumId = $album->id;

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
    function admin_can_delete_an_artistes_single_album()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->artisteUser->id
        ]);
        $albumId = $album->id;

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
