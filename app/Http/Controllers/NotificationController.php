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
