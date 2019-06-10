<?php

namespace App\Repositories\Eloquent;

use App\Models\Rating;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Contracts\Repositories\RatingRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RatingRepositoryEloquent.
 */
final class RatingRepositoryEloquent extends BaseRepository implements RatingRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Rating::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
