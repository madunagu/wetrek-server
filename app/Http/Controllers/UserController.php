<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }

        //THIS LINE WAS COMMENTED TO ENABLE UNVERIFIED USERS
        //$credentials['is_verified'] = 1;
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $token = $user->createToken('devotion')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'success' => true
            ], 200);
        }

        return response()->json(['success' => false, 'error' => 'incorrect username or password'], 401);
    }
}
