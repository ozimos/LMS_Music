<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Contracts\ResponseInterface;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Contracts\Repositories\CommentRepository;

/**
 * Class CommentsController.
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
     */
    public function update(CommentUpdateRequest $commentUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($commentUpdateRequest, $id);
    }

    public function respondWithCollection($models)
    {
        return  CommentResource::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(CommentResource::class, ['resource' => $model]);
    }
}
