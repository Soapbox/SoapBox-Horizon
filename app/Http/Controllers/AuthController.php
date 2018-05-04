<?php

namespace App\Http\Controllers;

use App\Whitelist;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class AuthController
{
    /**
     * Initiate the login flow
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Finalize the login flow
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(): RedirectResponse
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

    /**
     * Log the current user out
     *
     * @return \Illuminate\View\View
     */
    public function logout(): View
    {
        Auth::logout();
        return view('logout');
    }
}
