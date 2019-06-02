<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProfileResource extends JsonResource
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
            'content' => $this->content,
            'website' => $this->website,
            'twitter' => $this->twitter,
            'user_id' => $this->user_id,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
