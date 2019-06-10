<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'artiste' => new ProfileResource($this->whenLoaded('artiste')),
            'description' => $this->description,
            'release_date' => $this->release_date,
            'image' => $this->image,
        ];
    }
}
