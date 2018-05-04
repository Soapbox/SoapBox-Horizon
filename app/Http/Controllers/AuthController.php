<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $emails = collect(Redis::smembers('soapbox-horizon:emails'));

        if (!$emails->contains($user->email)) {
            abort(403);
        }

        Redis::hmset("soapbox-horizon:users:{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        Auth::loginUsingId($user->id);

        return Redirect::to('/horizon');
    }
}
