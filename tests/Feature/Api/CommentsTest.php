<?php

namespace Tests\Feature\Api;

use App\Models\Comment;
use Tests\ControllerTestCase;

class CommentsTest extends ControllerTestCase
{
    
    private $endpoint = 'api/v1/comments';
    

    /** @test */
    function user_can_view_all_comments()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id
            ]);

        // Act
        $response = $this->get("{$this->endpoint}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $comment->content,
            'user_id' => $comment->user_id
        ]);
    }

    /** @test */
    function user_can_view_a_single_comment()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id
        ]);

        // Act
        $response = $this->get("{$this->endpoint}/{$comment->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $comment->content,
            'user_id' => $comment->user_id
        ]);
    }

    /** @test */
    function user_can_create_a_single_comment()
    {
        $comment = factory(Comment::class)->make([
            'user_id' => $this->user->id
        ]);
        $input = [
            'content' => $comment->content,
        ];

        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('POST', $this->endpoint, $input);
        // Assert
        // $response->assertStatus(201);
        $response->assertJsonFragment([
            'content' => $comment->content,
            'user_id' => $comment->user_id
        ]);
    }

    /** @test */
    function user_can_update_a_single_comment()
    {
        $oldComment = factory(Comment::class)->create([
            'user_id' => $this->user->id
        ]);
        $newInput = [
            'content' => 'Updated test comment',
        ];
        // Act
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', "{$this->endpoint}/{$oldComment->id}", $newInput);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'content' => $newInput['content'],
            'user_id' => $oldComment->user_id
        ]);
        
    }

    /** @test */
    function user_can_delete_a_single_comment()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id
        ]);
        $commentId = $comment->id;
        // Act
        $deleteResponse = $this->delete("{$this->endpoint}/{$commentId}");
        $getResponse = $this->get("{$this->endpoint}/{$commentId}");
        // Assert
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJsonFragment([
            'message' => 'Model deleted.',
            'deleted' => true,
            ]);

        $getResponse->assertStatus(404);
    }
}
