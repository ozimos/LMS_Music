<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Contracts\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class CommentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CommentsController extends Controller
{
    use CrudMethodsTrait;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * CommentsController constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
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
}
