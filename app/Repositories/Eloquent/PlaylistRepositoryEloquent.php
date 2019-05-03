<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\PlaylistRepository;
use App\Models\Playlist;
use App\Validators\PlaylistValidator;

/**
 * Class PlaylistRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
final class PlaylistRepositoryEloquent extends BaseRepository implements PlaylistRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Playlist::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
