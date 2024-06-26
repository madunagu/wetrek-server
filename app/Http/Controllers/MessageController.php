<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageSent;
use App\Events\PrivateMessageSent;
use App\Http\Resources\MessageCollection;
use App\Message;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'string|required',
            'is_group' => 'nullable|bool',
            'to' => 'integer|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = Auth::user();
        $data = collect($request->all())->toArray();
        $data['sender_id'] = $user->id;
        $data['messagable_id'] = $data['to'];
        $data['grouper']  = min($user->id, $request['to']) ."". max($user->id, $request['to']);
        // $data['reciever_id'] = (int)$request->route('id');
        if (!empty($data['is_group'])) {
            $data['messagable_type'] = 'trek';
        } else {
            $data['messagable_type'] = 'user';
        }

        $result = Message::create($data);

        //Broadcast message into socket listeners
        if (!empty($data['is_group'])) {
            event(new GroupMessageSent($result));
        } else {
            event(new PrivateMessageSent($result));
        }


        if ($result) {
            $message = Message::find($result->id);
            return response()->json(['data' => $message], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function chats(Request $request)
    {
        $length = (int)$request['length'];
        $user = User::with('treks')->find(Auth::id());
        $userId = $user->id;
        $treks = $user->treks->pluck('id');
        $query = Message::where(function (Builder $query) use ($treks) {
            return $query->where('messagable_type', 'trek')
                ->whereIn('messagable_id', $treks);
        })
            ->orWhere(function ($query) use ($userId) {
                //for recieved messages
                return $query
                    ->where('messagable_type', '=', 'user')
                    ->where('messagable_id', '=', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                //for sent messages
                return $query
                    ->where('messagable_type', '=', 'user')
                    ->where('sender_id', '=', $userId);
            })
            // ->leftJoin('messages_seen','messages.id','messages_seen.message_id')
            ->select(['*', DB::raw('COUNT(*) AS message_count')])
            ->groupBy(['messagable_type', 'grouper'])
            ->orderBy('id', 'DESC');
        $data = $query->paginate($length);
        $data = new MessageCollection($data);
        return response()->json($data);
    }

    public function list(Request $request)
    {
        $id = (int)$request->input('id');
        $isTrekGroup = (bool)$request->input('is_group');
        $userId = Auth::id();
        $length = (int)$request->input('length') ?? 15;
        if ($isTrekGroup) {
            $query = Message::where(['messagable_id' => $id, 'messagable_type' => 'trek']);
        } else {
            $query = Message::where(function ($query) use ($userId, $id) {
                //for recieved messages
                return $query
                    ->where('messagable_type', '=', 'user')
                    ->where('messagable_id', '=', $userId)
                    ->where('sender_id', '=', $id);
            })
                ->orWhere(function ($query)  use ($userId, $id) {
                    // for sent messages
                    return $query
                        ->where('messagable_type', '=', 'user')
                        ->where('messagable_id', '=', $id)
                        ->where('sender_id', '=', $userId);
                });
        }
        $query = $query->orderBy('id', 'DESC');
        $data = $query->paginate($length);
        $data = new MessageCollection($data);
        return response()->json($data);
    }


    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($message = Message::find($id)) {
            return response()->json([
                'data' => $message
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }


    public function delete(Request $request)
    {
        $id = $request->route('id');
        $message = Message::findOrFail($id);
        if ($message->delete()) {
            return response()->json(['data' => true], 200);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }
}
