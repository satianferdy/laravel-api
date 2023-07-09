<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //login
    public function login(AuthLoginRequest $request)
    {
        // request validation
        // check if user exist
        $user = User::where('email', $request->email)->first();

        // check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        // create token
        $token = $user->createToken('token')->plainTextToken;

        // return response
        return new LoginResource([
            'user' => $user,
            'token' => $token
        ]);
    }

    // register
    public function register(Request $request)
    {

    }

    // logout
    public function logout(Request $request)
    {

    }
}
