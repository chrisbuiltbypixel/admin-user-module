<?php

namespace Modules\AdminUser\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
        ];

    }
}
