<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageSent;
use App\Events\PrivateMessageSent;
use App\Message;
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
            'reciever_id' => 'integer|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['sender_id'] = Auth::user()->id;
        // $data['reciever_id'] = (int)$request->route('id');

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

    public function list(Request $request)
    {
        $length = $request['length'];
        $userId = Auth::user()->id;
        $query = Message::where(['reciever_id' => $userId])
            ->groupBy(['sender_id', 'is_group'])
            ->orderBy(['id' => 'DESC']);
        $data = $query->paginate($length);
        return response()->json(compact('data'));
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        $length = $request['length'];
        $isTrekGroup = (bool)$request['is_group'];
        $userId = Auth::user()->id;

        $query = Message::where(['reciever_id' => $userId, 'sender_id' => $id]);
        if ($isTrekGroup) {
            $query = $query->where('is_group', 'true');
        }
        $query = $query->orderBy(['id' => 'DESC']);
        $data = $query->paginate($length);
        return response()->json(compact('data'));
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
