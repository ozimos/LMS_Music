<?php

namespace App\Contracts\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AlbumRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface AlbumRepository extends RepositoryInterface
{
     public function createSong (array $data, $model);
     public function updateSong (array $data, $model, string $id);
     public function deleteSong ($model, string $id);
}
