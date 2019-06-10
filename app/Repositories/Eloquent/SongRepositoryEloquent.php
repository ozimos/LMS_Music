<?php

namespace App\Repositories\Eloquent;

use App\Models\Song;
use App\Contracts\Repositories\SongRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SongRepositoryEloquent.
 */
final class SongRepositoryEloquent extends BaseRepository implements SongRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Song::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
