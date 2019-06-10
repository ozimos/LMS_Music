<?php

namespace App\Repositories\Eloquent;

use App\Models\Song;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Repositories\AlbumRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AlbumRepositoryEloquent.
 */
final class AlbumRepositoryEloquent extends BaseRepository implements AlbumRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Album::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function createSong(array $data, $album)
    {
        return $album->songs()->create($data);
    }

    public function updateSong(array $data, $album, $id)
    {
        $album->songs()->where('id', $id)->update($data);

        return $album->songs()->where('id', $id)->first();
    }

    public function deleteSong($album, $id)
    {
        $song = $album->songs()->where('id', $id)->first();
        if (empty($song)) {
            return false;
        }
        Storage::delete($song->file);

        return Song::destroy($song->id);
    }
}
