<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Address;
use App\Http\Resources\DefaultCollection;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formatted_address' => 'string|required',
            'place_id' => 'nullable|string|max:255',
            'plus_code' => 'nullable|json',
            'types' => 'nullable|array',
            'geometry' => 'nullable',
            'address_components' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        // logger($data);

        // $data = $this->parseLocation($data);
        $data['user_id'] = Auth::user()->id;
        if (!empty($data['geometry'])) {
            $data['geometry'] = json_encode($data['geometry']);
        }
        if (!empty($data['address_components'])) {
            $data['address_components'] = json_encode($data['address_components']);
        }
        if (!empty($data['fields'])) {
            $data['fields'] = json_encode($data['fields']);
        }
        $result = Address::create($data);

        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function parseLocation(array $data): array
    {
        $data['lng'] = $data['geometry']['location']['lng'];
        $data['lat'] = $data['geometry']['location']['lat'];
        return $data;
    }



    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:addresses,id',
            'formatted_address' => 'string|required',
            'place_id' => 'nullable|string|max:255',
            'plus_code' => 'nullable|json',
            'types' => 'nullable|array',
            'geometry' => 'nullable',
            'address_components' => 'nullable|array',
            'lat' => 'nullable',
            'lng' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $id = $request->route('id');

        $data = collect($request->all())->toArray();

        $data['user_id'] = Auth::user()->id;
        $result = Address::find($id);
        //obtain longitude and latitude if they werent set
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
        if ($address = Address::find($id)) {
            return response()->json([
                'data' => $address
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {

        $query = (string) $request['q'];
        $lat = $request['lat'];
        $lng = $request['lng'];
        $addresses = Address::with(['treks']); //TODO: add chat group and map data
        if ($query) {
            $addresses = $addresses->search($query);
        }
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $addresses->paginate($length);
        $data = new DefaultCollection($data);
        return response()->json(compact('data'));
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($address = Address::find($id)) {
            $address->delete();
            return response()->json([
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
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
}
