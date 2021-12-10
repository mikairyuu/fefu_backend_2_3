<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController
{
    public function register(Request $request): JsonResponse
    {
        $input = $request->all();
        $input['login'] = strtolower($input['login']);
        $validator = Validator::make($input, User::$registrationRules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->all()], 403);
        } else {
            $user = new User;
            $user->name = $input['name'];
            $user->login = $input['login'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->save();
            return response()->json(['user' => new UserResource($user), 'token' => $user->createToken('API Token')->plainTextToken]);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $input = $request->all();
        $input['login'] = strtolower($input['login']);
        $validator = Validator::make($input, User::$loginRules);
        if ($validator->fails())
            return response()->json(['message' => $validator->messages()->all()], 403);
        Auth::attempt($request->toArray());
        $user = Auth::user();
        if ($user !== null) {
            return response()->json(['user' => new UserResource($user), 'token' => $user->createToken('API Token')->plainTextToken]);
        } else {
            return response()->json(['message' => 'Auth failed'], 401);
        }
    }


    public function profile(Request $request): JsonResponse
    {
        $user = Auth::user();
        return $user !== null ? response()->json(['user' => new UserResource($user)]) : response()->json(['message' => 'Auth failed'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user !== null)
            $user->tokens()->delete();
        return $user !== null ? response()->json(['message' => 'Successfully logged out']) : response()->json(['message' => 'Auth failed'], 401);
    }
}
