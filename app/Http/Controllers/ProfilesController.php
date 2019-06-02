<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Contracts\Repositories\ProfileRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProfileResource;
use App\Contracts\ResponseInterface;

/**
 * Class ProfilesController.
 *
 * @package namespace App\Http\Controllers;
 */
final class ProfilesController extends Controller implements ResponseInterface
{
    use CrudMethodsTrait;

    /**
     * @var ProfileRepository
     */
    protected $repository;

    /**
     * ProfilesController constructor.
     *
     * @param ProfileRepository $repository
     */
    public function __construct(ProfileRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('isArtiste')->only(['store', 'update']);
        $this->middleware('isArtisteOrAdmin')->only(['destroy']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProfileCreateRequest $profileCreateRequest
     *
     * @return JsonResponse
     *
     */
    public function store(ProfileCreateRequest $profileCreateRequest)
    {
        return $this->storeFromFormCreateRequest($profileCreateRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileUpdateRequest $profileUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    public function update(ProfileUpdateRequest $profileUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($profileUpdateRequest, $id);
    }

    public function respondWithCollection($models)
    {
        return  ProfileResource::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(ProfileResource::class, ['resource' => $model]);
    }
}
