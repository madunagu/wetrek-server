<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Validation\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Trek;
use App\Http\Resources\TrekCollection;
use App\Address;
use App\Location;
use App\MapDirection;
use App\Notifications\TrekStarting;
use App\Position;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

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

        $user =  Auth::user();
        $data = collect($request->all())->toArray();
        $data['user_id'] = $user->id;
        $startAddress = Address::create($request['start_address']);
        $endAddress = Address::create($request['end_address']);
        $data['start_address_id'] = $startAddress->id;
        $data['end_address_id'] = $endAddress->id;
        $data['start_longitude'] = $request['directions']['routes']['legs'][0]['start_location']['lat'];
        $data['start_latitude'] = $request['directions']['routes']['legs'][0]['start_location']['lng'];
        $directionData = json_encode($request['directions']);
        $direction = MapDirection::create(['direction'=> $directionData]);
        $data['direction_id'] = $direction->id;
        $result = Trek::create($data);

        // $creatorAttending = $result->users()->toggle([$userId]);
        $creatorAttending = DB::table('trek_user')->where(['user_id' => $user->id, 'trek_id' => $result->id]);
        if (empty($creatorAttending)) {
            DB::table('trek_user')->create(['user_id' => $user->id, 'trek_id' => $result->id, 'confirmed_at' => Carbon::now()]);
        }
        //TODO: create event emmiter or reminder or notifications for those who may be interested
        // Notification::send($user, new TrekStarting($result));

        if ($result) {
            $trek = Trek::find($result->id);
            return response()->json(['data' => $trek], 201);
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
        $user = Auth::user();
        if ($event = Trek::with(['direction'])->find($id)) {
            $event->is_attending = $user->treks->pluck('id')->contains($event->id);
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
            'post_dated' => 'nullable|string',
            'attended' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $query = $request['q'];
        if (!empty($request['post_dated'])) {
            $timeNow = Carbon::now();
            $treks = Trek::where(['starting_at', '>', $timeNow])->withCount(['users']); //TODO: add chat group and map data
        } else if (!empty($request['attended'])) {
            $user = Auth::user();
            $treks = $user->treks()->withCount(['users']);
        } else {
            $treks = Trek::withCount(['users']);
        }
        if ($query) {
            $treks = $treks->search($query);
        }
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $treks = $treks->orderBy('starting_at', 'DESC');
        $treks = $treks->paginate($length);
        $data = new TrekCollection($treks);
        return response()->json($data);
    }


    public function join(Request $request)
    {
        $id = (int)$request->route('id');
        $user = Auth::user();
        $trek = Trek::find($id);
        $attached = $trek->users()->toggle([$user->id]);
        //TODO: change database time to php time here
        $when = $trek->starting_at;
        // Notification::send($user, (new TrekStarting($trek))->delay($when));
        return response()->json([
            'data' => !empty($attached['attached'])
        ], 200);
    }



    public function updatePosition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'longitude' => 'numeric|required|max:255',
            'latitude' => 'numeric|required|max:255',
            'timestamp' => 'numeric|required|max:255',
            'accuracy' => 'numeric|required|max:255',
            'altitude' => 'numeric|required|max:255',
            'heading' => 'numeric|required|max:255',
            'speed' => 'numeric|required|max:255',
            'speed_accuracy' => 'numeric|required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $data = collect($request->all())->toArray();
        $user = Auth::user();

        $data['user_id'] = $user->id;
        $position = Position::create($data);
        $active_treks = $user->treks()->wherePivot('status', 'started')->get(); //->pluck('treks.id');
        // DB::table('trek_user')->where(['user_id' => $user->id])->whereNull('ended_at')
        //     ->whereIn('trek_id', $trek_ids)->update([
        //         'status' => 'moving'
        //     ]);
        //here update status of trek near location
        foreach ($active_treks as $trek) {
            // $lat =$trek->start_latitude;
            // $lng = $trek->start_longitude;
            $loc = $trek->location();
            // $distance = $this->haversineGreatCircleDistance($loc['lat'], $loc['lng'], $data['latitude'], $data['longitude']);
            if ($this->is_close_enough($loc['lat'], $loc['lng'], $data['latitude'], $data['longitude'])) {
      
                $user->treks()->updateExistingPivot($trek->id, [
                    'status' => 'moving',
                ]);
            }
        }


        //TODO: here perform geofencing operations
        //step 1: gather all active coordinates --
        //step 2: fence the coordinates and remove the points far from the center
        //step 3: find the average of the coordinates 
        // return collect($data)->median("price"); 

        return response()->json([
            'sucess' => true,
            'data' => $position,
        ]);
    }

    public function is_close_enough($lat1, $lng1, $lat2, $lng2): bool
    {
        return $this->haversineGreatCircleDistance($lat1, $lng1, $lat2, $lng2) < 50; //meters
    }

    function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius; //meters
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
