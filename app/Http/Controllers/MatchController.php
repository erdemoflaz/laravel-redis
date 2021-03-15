<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndGameRequest;
use App\Http\Resources\EndedMatchResources;
use App\Http\Resources\LeaderBoardResources;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MatchController extends Controller
{
    /**
     * @param EndGameRequest $request
     * @return mixed
     */
    public function endMatch(Request $request)
    {
        $ended_matches = $request->all();

        foreach ($ended_matches as $key => $matches) {

            $matchId = $this->getMatchId();

            $this->addMatch($matchId, [
                'user_id' => $matches['user_id'],
                'score' => $matches['score'],
                'created_at' => Carbon::now()
            ]);
            Redis::hGetAll("matches:$matchId");
        }

        return new EndedMatchResources($ended_matches);
    }

    /**
     * @return mixed
     */
    static function getMatchId()
    {
        if(!Redis::exists('match_count'))
            Redis::set('match_count', 0);

        return Redis::incr('match_count');
    }

    /**
     * @param $matchId
     * @param $data
     */
    public function addMatch($matchId, $data)
    {
        Redis::hmset("matches:$matchId", $data);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function leaderBoard()
    {
        $keys = Redis::keys('matches:*');
        $matches = [];
        foreach ($keys as $index => $key) {
            $match = explode(":", $key);
            $matches[$index] = Redis::hGetAll('matches:'.$match[1]);
            Redis::hGetAll('matches:'.$match[1]);
        }
        $matches = collect($matches)->sortByDesc('score');

        return LeaderBoardResources::collection($matches);
    }
}
