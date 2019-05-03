<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\SongRepository;
use App\Models\Song;
use App\Validators\SongValidator;

/**
 * Class SongRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
final class SongRepositoryEloquent extends BaseRepository implements SongRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Song::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
