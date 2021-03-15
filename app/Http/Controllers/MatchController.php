<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndGameRequest;
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

        return response()->json([
            'status' => 200,
            'timestamp' => Carbon::now(),
            'results' => [
                'user_points' => [
                    'player_1_id' => $ended_matches[0]['user_id'],
                    'player_1_score' => $ended_matches[0]['score'],
                    'player_2_id' => $ended_matches[1]['user_id'],
                    'player_2_score' => $ended_matches[1]['score'],
                ]
            ]
        ]);
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
     * @return \Illuminate\Support\Collection
     */
    public function leaderBoard()
    {
        $keys = Redis::keys('matches:*');
        $matches = [];
        foreach ($keys as $index => $key) {
            $match = explode(":", $key);
            $matches[$index] = Redis::hGetAll('matches:'.$match[1]);
            Redis::sadd('leaderboard', Redis::hGetAll('matches:'.$match[1]));
        }

        return collect($matches)->sortByDesc('score');
    }
}
