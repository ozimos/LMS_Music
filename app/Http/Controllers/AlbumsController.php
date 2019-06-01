<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumCreateRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Contracts\Repositories\AlbumRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AlbumResource;
use App\Contracts\ResponseInterface;

/**
 * Class AlbumsController.
 *
 * @package namespace App\Http\Controllers;
 */
final class AlbumsController extends Controller implements ResponseInterface
{
    use CrudMethodsTrait;

    /**
     * @var AlbumRepository
     */
    protected $repository;

    /**
     * AlbumsController constructor.
     *
     * @param AlbumRepository $repository
     */
    public function __construct(AlbumRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('isArtiste')->only(['store', 'update']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AlbumCreateRequest $albumCreateRequest
     *
     * @return JsonResponse
     *
     */
    public function store(AlbumCreateRequest $albumCreateRequest)
    {
        return $this->storeFromFormCreateRequest($albumCreateRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AlbumUpdateRequest $albumUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    public function update(AlbumUpdateRequest $albumUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($albumUpdateRequest, $id);
    }

    public function respondWithCollection($models)
    {
        return  AlbumResource::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(AlbumResource::class, ['resource' => $model]);
    }
}
