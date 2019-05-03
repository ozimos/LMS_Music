<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\GenreRepository;
use App\Models\Genre;
use App\Validators\GenreValidator;

/**
 * Class GenreRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
final class GenreRepositoryEloquent extends BaseRepository implements GenreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Genre::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
