<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Contracts\ResponseInterface;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserUpdateRequest;
use App\Contracts\Repositories\UserRepository;

final class UserController extends Controller implements ResponseInterface
{
    use CrudMethodsTrait;

    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('isAdmin')->only(['index', 'destroy']);
        $this->middleware('isAdminOrSelf')->only(['show', 'update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $userUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $userUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($userUpdateRequest, $id, 'pass');
    }

    public function respondWithCollection($models)
    {
        return  UserResource::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(UserResource::class, ['resource' => $model]);
    }
}
