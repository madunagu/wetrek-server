<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Validation\Validator;

use Illuminate\Support\Facades\Auth;
use Validator;

use App\Trek;
use App\Http\Resources\TrekCollection;
use App\Address;
use App\Location;
use Carbon\Carbon;

class TrekController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'start_address' => 'required',
            'end_address' => 'required',
            'directions' => 'required',
            'starting_at' => 'nullable|date',
            'repeat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $startAddress = Address::create($request['start_address']);
        $endAddress = Address::create($request['end_address']);
        $data['start_address_id'] = $startAddress->id;
        $data['end_address_id'] = $endAddress->id;
        $data['direction'] = json_encode($request['directions']);
        $result = Trek::create($data);
        //TODO: create event emmiter or reminder or notifications for those who may be interested

      
        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:treks,id',
            'name' => 'string|required|max:255',
            'start_address' => 'required|string',
            'end_address' => 'required|string',
            'directions' => 'required|string',
            'starting_at' => 'nullable|date',
            'repeat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();

        $user_id = Auth::user()->id;
        $id = $request->route('id');
        $trek = Trek::find($id);
        if ($user_id == $trek->user_id)
            $result = $trek->update($data);
        else
            //TODO: throw unauthorized exception
            return response()->json(['data' => false], 422);

        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($event = Trek::find($id)) {
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
            'q' => 'nullable|string',
            'p' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $query = $request['q'];
        $postDatedTreks = !empty($request['p']);
        if ($postDatedTreks) {
            $timeNow = Carbon::now();
            $treks = Trek::where(['starting_at', '>', $timeNow])->withCount(['users']); //TODO: add chat group and map data
        } else {
            $treks = Trek::withCount(['users']);
        }
        if ($query) {
            $treks = $treks->search($query);
        }
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $treks = $treks->paginate($length);
        $data = new TrekCollection($treks);
        return response()->json($data);
    }


    public function join(Request $request)
    {
        $id = (int)$request->route('id');
        $user = Auth::user();
        $trek = Trek::find($id);
        $trek->users()->attach([
            1 => [
                'trek_id' => $id,
                'user_id' => $user->id,
                // 'confirmed' => true
            ]
        ]);
        //TODO change database time to php time here
        $when = $trek->starting_at;
        // Notification::send($user, (new TrekStarting($trek))->delay($when));
        return response()->json([
            'data' => true
        ], 200);
    }



    public function updateLocation(Request $request)
    {

        $id = (int)$request->route('id');
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:user,id',
            'lon' => 'string|required|max:255',
            'lat' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $data = collect($request->all())->toArray();

        $trek = Trek::find($id);

        $location = Location::create($data);

        $trek->locations()->attach($location->id);
        return response()->json([
            'sucess' => true,
        ]);
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
