<?php

namespace App\Http\Controllers;

use App\Whitelist;
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

        if (!Whitelist::contains($user->email)) {
            abort(403);
        }

        Redis::hmset("user:{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        Auth::loginUsingId($user->id);

        return Redirect::to('/horizon');
    }

    public function logout()
    {
        Auth::logout();
        return view('logout');
    }
}
