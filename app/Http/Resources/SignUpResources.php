<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SignUpResources extends JsonResource
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
            'status' => 200,
            'timestamp' => $this['created_at'],
            'result' => [
                'id' => (int)$this['user_id'],
                'password' => $this['password'],
                'username' => $this['username'],
            ]
        ];
    }
}
