<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SongRepository;
use App\Http\Resources\SongResource;
use App\Contracts\ResponseInterface;

/**
 * Class SongsController.
 *
 * @package namespace App\Http\Controllers;
 */
final class SongsController extends Controller implements ResponseInterface
{
    use CrudMethodsTrait;

    /**
     * @var SongRepository
     */
    protected $repository;

    /**
     * SongsController constructor.
     *
     * @param SongRepository $repository
     */
    public function __construct(SongRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('isArtiste')->only(['store', 'update']);
    }

    public function respondWithCollection($models)
    {
        return  SongResource::collection($models);
    }

    public function respondWithItem($model)
    {
        return app(SongResource::class, ['resource' => $model]);
    }
}
