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

    public function user(Request $request)
    {
        return User::find(Auth::id())->with(['location', 'images'])->withCount(['following', 'followers']);
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

    public function followers(Request $request){
        $validator = Validator::make($request->all(), [
            'q' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user_id = Auth::id();

        $query = $request['q'];
        $users = User::where([]); //TODO: add chat group and map data
        if ($query) {
            $treks = $treks->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $treks = $treks->paginate($length);
        $data = new UserCollection($treks);
        return response()->json($data);
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
