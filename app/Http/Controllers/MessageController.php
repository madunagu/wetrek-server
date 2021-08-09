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

        $data = collect($request->all())->toArray();
        $data['sender_id'] = Auth::user()->id;
        $data['messagable_id'] = $data['to'];
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
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function chats(Request $request)
    {
        $length = (int)$request['length'];
        $user = User::with('treks')->find(Auth::id());
        $treks = $user->treks->pluck('id');
        $query = Message::where(['messagable_id' => $user->id, 'messagable_type' => 'user'])
            ->orWhere(function (Builder $query) use ($treks) {
                return $query->where('messagable_type', 'trek')
                    ->whereIn('messagable_id', $treks);
            })
            // ->groupBy(['sender_id','messagable_type', 'messagable_id','id','message','sender_id','created_at','updated_at'])
            ->orderBy('id', 'DESC');
        $data = $query->paginate(15);
        $data = new MessageCollection($data);
        return response()->json($data);
    }

    public function list(Request $request)
    {
        $id = (int)$request->input('chat_id');
        $isTrekGroup = (bool)$request['is_group'];
        $userId = Auth::id();
        $length = (int)$request['length'] ?? 15;
        if ($isTrekGroup) {
            $query = Message::where(['messagable_id' => $id, 'messagable_type' => 'trek']);
        } else {
            $query = Message::where(['messagable_id' => $userId, 'messagable_type' => 'user', 'sender_id' => $id]);
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
