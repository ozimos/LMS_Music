<?php

namespace Tests\Feature\Api;

use App\Models\Song;
use App\User;
use Tests\ControllerTestCase;

class SongsTest extends ControllerTestCase
{
    
    private $endpoint = 'api/v1/songs';
    
    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true
        ]);
        $this->artisteUser = $artisteUser;
    }

    /** @test */
    function user_can_view_all_songs()
    {
        $song = factory(Song::class)->create();

        // Act
        $response = $this->get($this->endpoint);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $song->title,
            'file' => $song->file,
            'url' => "/storage/{$song->file}"
        ]);
    }

    /** @test */
    function user_can_view_a_single_song()
    {
        $song = factory(Song::class)->create();

        // Act
        $response = $this->get("{$this->endpoint}/{$song->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $song->title,
            'file' => $song->file,
            'url' => "/storage/{$song->file}"
        ]);
    }
}
