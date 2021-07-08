<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

use Validator;

class UserController extends Controller
{
    public function get(Request $request)
    {
        return User::find(Auth::id())->with('following');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        //THIS LINE WAS COMMENTED TO ENABLE UNVERIFIED USERS
        //$credentials['is_verified'] = 1;
        if ($this->attemptLogin($credentials)) {
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

    public function register(Request $request)
    {

        // $credentials = $request->only('email', 'password');
        $credentials = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        $user = User::create($credentials);
        $token = $user->createToken('devotion')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'success' => true
        ], 200);
        //THIS LINE WAS COMMENTED TO ENABLE UNVERIFIED USERS
        //$credentials['is_verified'] = 1;
    }


    protected function attemptLogin($credentials)
    {
        return $this->guard()->attempt(
            $credentials
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
