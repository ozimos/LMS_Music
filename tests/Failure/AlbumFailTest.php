<?php

namespace Tests\Failure;

use App\User;
use App\Models\Album;
use Tests\ControllerTestCase;

class AlbumFailTest extends ControllerTestCase
{
    private $endpoint = 'api/v1/albums';

    public function setUp(): void
    {
        parent::setUp();
        $artisteUser = factory(User::class)->create([
            'isArtiste' => true
        ]);
        $anotherArtisteUser = factory(User::class)->create([
            'isArtiste' => true
        ]);
        $adminUser = factory(User::class)->create([
            'isAdmin' => true,
            'isArtiste' => true
        ]);

        $this->anotherArtisteUser = $anotherArtisteUser;
        $this->artisteUser = $artisteUser;
        $this->adminUser = $adminUser;
    }

    /** 
     * @test
     */
    function artiste_try_to_create_not_own_album_song()
    {
        $album = factory(Album::class)->create([
            'user_id' => $this->anotherArtisteUser->id
        ]);
        $input = [
            'title' => 'some title',
            'description' => 'some/random/url'
        ];
        $this->actingAs($this->artisteUser, 'api');

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', "{$this->endpoint}/{$album->id}/songs", $input);

        // Assert
        $response->assertStatus(403);
        $response->assertJsonFragment(
            [
                'error' => 
                "you do not have update-model permissions for model with id {$album->id}"
            ]
        );
    }
}
