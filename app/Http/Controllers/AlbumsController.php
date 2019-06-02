<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\SongCreateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\SongUploadRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Http\Requests\AlbumCreateRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Contracts\Repositories\AlbumRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\SongResource;
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
        $this->middleware('isArtiste')->except(['index', 'destroy', 'show', 'deleteSong']);
        $this->middleware('isArtisteOrAdmin')->only(['destroy', 'deleteSong']);
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

    public function createSong(SongCreateRequest $songCreateRequest, $albumId)
    {
        $album = $this->canEditModel($albumId);

        $song = $this->repository->createSong($songCreateRequest->validated(), $album);
        return app(SongResource::class, ['resource' => $song])
            ->response()
            ->setStatusCode(201);  
    }  

    public function updateSong(SongUpdateRequest $songUpdateRequest, $albumId, $songId)
    {
        $album = $this->canEditModel($albumId);

        $song = $this->repository->updateSong($songUpdateRequest->validated(), $album, $songId);
        return app(SongResource::class, ['resource' => $song]);  
    } 

    public function deleteSong(Request $request, $albumId, $songId)
    {
        $album = $this->canEditModel($albumId, 'delete-model');

        $deleted = $this->repository->deleteSong($album, $songId);
        return response()->json([
            'message' => 'Model deleted.',
            'deleted' => (bool)$deleted,
        ]); 
    }  

    public function uploadSong(SongUploadRequest $songUploadRequest, $albumId, $songId)
    {
        $album = $this->canEditModel($albumId);
        $song = $songUploadRequest->song;
        $path = $song->store('song');
        $song = $this->repository->updateSong(['file' => $path], $album, $songId);
        return app(SongResource::class, ['resource' => $song]);  
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
