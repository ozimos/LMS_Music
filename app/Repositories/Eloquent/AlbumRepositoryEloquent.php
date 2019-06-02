<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\AlbumRepository;
use App\Models\Album;
use App\Validators\AlbumValidator;

/**
 * Class AlbumRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
final class AlbumRepositoryEloquent extends BaseRepository implements AlbumRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Album::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function createSong (array $data, $album)
    {
        return $album->songs()->create($data);
    }

    public function updateSong (array $data, $album, $id)
    {
        $album->songs()->where('id', $id)->update($data);
        return $album->songs()->where('id', $id)->first();
    }

    public function deleteSong ($album, $id)
    {
        return $album->songs()->where('id', $id)->delete();
    }
    
}
