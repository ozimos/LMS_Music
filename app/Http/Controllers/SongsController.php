<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SongRepository;
use App\Http\Resources\SongResource;
use Illuminate\Support\Facades\Storage;
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

    public function respondWithCollection($songs)
    {
        $songs = $songs->map(function($song){
            return $this->convertFilePathsToURL($song);
        });
        
        return  SongResource::collection($songs);
    }

    public function respondWithItem($song)
    {
        $song = $this->convertFilePathsToURL($song);
        return app(SongResource::class, ['resource' => $song]);
    }

    protected function convertFilePathsToURL($song)
    {
        $song->url = Storage::url($song->file);
        return $song;
    }
}
