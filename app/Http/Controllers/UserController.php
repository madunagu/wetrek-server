<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Trek;
use App\Http\Resources\DefaultCollection;
use App\Notifications\TrekStarting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        return User::with('following')->find($id);
    }

    public function user(Request $request)
    {
        $user = User::with(['locations', 'picture'])->withCount(['followers', 'following'])->find(Auth::id());
        return response()->json($user, 200);
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
            $user->notifications_count = $user->unreadNotifications->count();
            $token = $user->createToken('devotion')->accessToken;
            $user->makeHidden('unreadNotifications'); 

            return response()->json([
                'user' => $user,
                'token' => $token,
                'success' => true
            ], 200);
        }

        return response()->json(['success' => false, 'error' => 'incorrect username or password'], 401);
    }


    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'nullable|string',
            'followers' => 'nullable|numeric',
            'following' => 'nullable|numeric',
            'trek' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);

        $followersOfId = $request['followers'] ?? $request['following'];
        $trekId = $request['trek'];
        $userId = Auth::id();

        $users = User::with(['locations', 'picture'])->withCount(['followers', 'following'])
            ->withCount(['isFollowing' => function (Builder $query) use ($userId) {
                $query->where('follower_id', $userId);
            }]);
        //TODO: add chat group and map data
        if ($query) {
            $users = $users->search($query);
        }
        if (!empty($request['followers'])) {
            $users = User::find($followersOfId)->followers();
        } else if (!empty($request['following'])) {
            $users = User::find($followersOfId)->following();
        } else if (!empty($request['trek'])) {
            $users = Trek::find($trekId)->users();
        }
        //here insert search parameters and stuff
        $users = $users->paginate($length);
        $data = new DefaultCollection($users);
        return response()->json($data);
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


    public function follow(Request $request)
    {
        $following_id = $request->route('id');
        $user = Auth::user();
        $user->following()->toggle([$following_id]);
        $user->notify(new TrekStarting(Trek::find(1)));
        return response()->json(['success' => true]);
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
