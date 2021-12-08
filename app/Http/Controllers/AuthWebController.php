<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AuthWebController
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['login'] = strtolower($input['login']);
            $validator = Validator::make($input, User::$loginRules);
            if ($validator->valid()) {
                if (Auth::attempt(['login' => $input['login'], 'password' => $input['password']], true))
                    return redirect(route('web_profile'));
            }
            return view('loginForm',
                ['errors' => $validator->fails() ? $validator->messages() : new MessageBag(['Login failed'])]);
        } else {
            return view('loginForm');
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['login'] = strtolower($input['login']);
            $validator = Validator::make($input, User::$registrationRules);
            if ($validator->fails()) {
                $request->flash();
                return view('registrationForm', ['errors' => $validator->getMessageBag()]);
            } else {
                $user = new User;
                $user->name = $input['name'];
                $user->login = $input['login'];
                $user->email = $input['email'];
                $user->password = Hash::make($input['password']);
                $user->save();
                Auth::login($user);
                return redirect(route('web_profile'));
            }
        } else {
            return view('registrationForm');
        }
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('web_login'));
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if ($user === null)
            return redirect(route('web_login'));
        return view('profile', ['userData' => (new UserResource($user))->toArray($request)]);
    }
}
