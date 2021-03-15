<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Resources\SignInResources;
use App\Http\Resources\SignUpResources;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return SignInResources|\Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request)
    {
        $keys = Redis::keys('user:*');
        foreach ($keys as $index => $key) {
            $user_key = explode(":", $key);
            $user = Redis::hGetAll('user:'.$user_key[1]);
            if ($user['username'] == $request->username && $user['password'] == $request->password) {

                return new SignInResources($user);
            }
        }

        return response()->json('User credentials not found', 401);
    }

    /**
     * @param SignupRequest $request
     * @return SignUpResources
     */
    public function signUp(SignupRequest $request)
    {
        $userId = $this->getUserId();
        $this->newUser($userId, [
            'user_id' => $userId,
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'created_at' => Carbon::now()
        ]);
        $user = Redis::hGetAll("user:$userId");

        return new SignUpResources($user);
    }

    /**
     * @return mixed
     */
    static function getUserId()
    {
        if(!Redis::exists('user_count'))
		   Redis::set('user_count', 0);

        return Redis::incr('user_count');
	 }

    /**
     * @param $userId
     * @param $data
     */
    public function newUser($userId, $data)
    {
        Redis::hMset("user:$userId", $data);
    }
}
