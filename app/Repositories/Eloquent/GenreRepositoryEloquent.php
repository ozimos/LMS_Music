<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Contracts\Repositories\GenreRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GenreRepositoryEloquent.
 */
final class GenreRepositoryEloquent extends BaseRepository implements GenreRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Genre::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
