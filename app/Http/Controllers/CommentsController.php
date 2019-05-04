<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Contracts\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Comment;
use App\Contracts\ResponseInterface;

/**
 * Class CommentsController.
 *
 * @package namespace App\Http\Controllers;
 */
final class CommentsController extends Controller implements ResponseInterface
{
    use CrudMethodsTrait;

    /**
     * @var CommentRepository
     */
    protected $repository;

    /**
     * CommentsController constructor.
     *
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CommentCreateRequest $commentCreateRequest
     *
     * @return JsonResponse
     *
     */
    public function store(CommentCreateRequest $commentCreateRequest)
    {
        return $this->storeFromFormCreateRequest($commentCreateRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentUpdateRequest $commentUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    public function update(CommentUpdateRequest $commentUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($commentUpdateRequest, $id);
    }

    public function respondWithCollection($models)
    {
        return  Comment::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(Comment::class, ['resource' => $model]);
    }
}
