<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'album_id' => $this->album_id,
            'release_date' => $this->release_date,
            'file' => $this->file,
            'url' => $this->url,
            'genre' => new GenreResource($this->whenLoaded('genre')),
            'album' => new AlbumResource($this->whenLoaded('album')),
        ];
    }
}
