<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user
     * @param UserLoginRequest $request
     * @return response
     */
    public function loginUser(UserLoginRequest $request) {
        $credentials = $request->only('email','password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Login failed.",
                "data" => null
            ],200);
        }
        $user = User::where('email',$request->email)->first();
        if (!$user) {
            return response()->json([
                "message" => "Login failed.",
                "data" => null
            ],401);
        }
        $tokenHolder = $user->createToken('bulletToken');
        if ($request->remember_me) {
            $token = $tokenHolder->token;
            $token->expires_at = Carbon::now()->addMinute(5);
            $token->save();
        }
        return response()->json([
                "message" => "Successfully login.",
                "token" => $tokenHolder->accessToken,
                "type" => $user->type,
                "user_name" => $user->name,
                "id" => $user->id
            ],200);
    }

    /**
     * Logout user
     * @param Request $request
     * @return response
     */
    public function logoutUser(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            "message" => "Successfully logout",
        ],200);
    }
}
