<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //login
    public function login(AuthLoginRequest $request)
    {
        //validate with Auth::attempt
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // if success, create token
            $user = User::where('email', $request->email)->first();
            //delete old token
            $user->tokens()->delete();
            //create new token
            $token = $user->createToken('token')->plainTextToken;
            return new LoginResource([
                'user' => $user,
                'token' => $token
            ]);
        } else {
            //if failed, return error
            return response()->json([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
    }

    // register
    public function register(AuthRegisterRequest $request)
    {
        // save to database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        // create token
        $token = $user->createToken('token')->plainTextToken;

        return new LoginResource([
            'user' => $user,
            'token' => $token
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        // revoke token by user
        $request->user()->currentAccessToken()->delete();
        // response success, no content
        return response()->noContent();
    }
}
