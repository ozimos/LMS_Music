<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\ArtisteRepository;
use App\Models\Artiste;
use App\Validators\ArtisteValidator;

/**
 * Class ArtisteRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
final class ArtisteRepositoryEloquent extends BaseRepository implements ArtisteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Artiste::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ArtisteValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
