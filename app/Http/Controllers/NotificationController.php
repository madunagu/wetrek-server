<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{


    public function list(Request $request)
    {
        $userId = Auth::id();
        $length = (int)$request['length'] ?? 15;
        $user = User::find($userId);

        $result = $user->notifications;
        // $query = Notification::where(['messagable_id' => $id, 'messagable_type' => 'trek']);
        // $query = $query->orderBy('id', 'DESC');
        // $data = $query->paginate($length);
        // $data = new MessageCollection($data);
        return response()->json($result);
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
