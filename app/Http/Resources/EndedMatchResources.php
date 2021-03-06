<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EndedMatchResources extends JsonResource
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
                'user_points' => [
                    'player_1_id' => $this[0]['user_id'],
                    'player_1_score' => $this[0]['score'],
                    'player_2_id' => $this[1]['user_id'],
                    'player_2_score' => $this[1]['score'],
                ]
            ]
        ];
    }
}
