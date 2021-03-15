<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Redis;

class LeaderBoardResources extends JsonResource
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
            'timestamp' => Carbon::now(),
            'results' => [
                'username' => $this->getUsername($this['user_id']),
                'user_id' => $this['user_id'],
                'rank' => $this['score'],
            ]
        ];
    }


    private function getUsername($userId)
    {
        return Redis::hGet('user:'.$userId, 'username');
    }
}
