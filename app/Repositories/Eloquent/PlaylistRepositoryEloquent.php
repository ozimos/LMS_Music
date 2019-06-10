<?php

namespace App\Repositories\Eloquent;

use App\Models\Playlist;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\PlaylistRepository;

/**
 * Class PlaylistRepositoryEloquent.
 */
final class PlaylistRepositoryEloquent extends BaseRepository implements PlaylistRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Playlist::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
