<?php

namespace App\Http\Resources\Url;


use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'link' => $this->link,
            'status' => $this->present()->result_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
