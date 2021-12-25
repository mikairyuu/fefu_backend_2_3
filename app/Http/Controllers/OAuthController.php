<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirect()
    {
        $driver = request('driver');
        if ($driver != 'github' && $driver != 'google') abort(404);
        return Socialite::driver($driver)->scopes(config('services.' . $driver . '.scopes'))->redirect();
    }

    public function callback()
    {
        if (!request()->has('code') || request()->has('denied')) {
            request()->session()->flash('errors', ['OAuth failed. Error: ' . request()->input('error') .
                ' Try some other way.']);
            return redirect(route('web_login'));
        }
        $driver = request('driver');
        if ($driver != 'github' && $driver != 'google') abort(404);
        $oauthuser = Socialite::driver($driver)->user();
        $user = User::where($driver . '_id', $oauthuser->id)->first();
        if ($user) {
            $user->update([
                $driver . '_id' => $oauthuser->getId(),
                $driver . '_login_date' => now()
            ]);
        } else {
            $user = User::where('email', $oauthuser->email)->where($driver . '_id', null)->first();
            if ($user) {
                $user->update([
                    $driver . '_id' => $oauthuser->getId(),
                    $driver . '_login_date' => now(),
                    $driver . '_registration_date' => now()
                ]);
            } else {
                $user = User::create([
                    'name' => $oauthuser->getName() ?? $oauthuser->getNickname(),
                    'email' => $oauthuser->getEmail(),
                    $driver . '_id' => $oauthuser->id,
                    $driver . '_login_date' => now(),
                    $driver . '_registration_date' => now()
                ]);
            }
        }
        Auth::login($user);

        return redirect(route('web_profile'));
    }
}
