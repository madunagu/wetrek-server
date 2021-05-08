<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Validation\Validator;

use Illuminate\Support\Facades\Auth;
use Validator;

use App\Trek;
use App\Http\Resources\TrekCollection;

class TrekController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'start_address_id' => 'nullable|integer',
            'end_address_id' => 'nullable|integer',
            'starting_at' => 'nullable|date',
            'ending_at' => 'nullable|date',
            'repeat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Trek::create($data);
        //create event emmiter or reminder or notifications for those who may be interested

        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:treks,id',
            'name' => 'string|required|max:255',
            'start_address_id' => 'nullable|integer',
            'end_address_id' => 'nullable|integer',
            'starting_at' => 'nullable|date',
            'ending_at' => 'nullable|date',
            'repeat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $id = $request->route('id');
        $result = Trek::find($id);
        //update result
        $result = $result->update($data);


        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($event = Trek::find($id)->with('users')) {
            return response()->json([
                'data' => $event
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'nullable|string|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $treks = Trek::with('church'); //TODO: add chat group and map data
        if ($query) {
            $treks = $treks->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $treks = $treks->paginate($length);
        $data = new TrekCollection($treks);
        return response()->json($data);
    }


    public function join(Request $request)
    {
        $id = (int)$request->route('id');
        $user_id = Auth::id();
        $trek = Trek::find($id);
        $trek->users()->create([
            'trek_id' => $id,
            'user_id' => $user_id,
            'confirmed' => true
        ]);
        return response()->json([
            'data' => true
        ], 200);
    }



    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($trek = Trek::find($id)) {
            $trek->delete();
            return response()->json([
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }
}
