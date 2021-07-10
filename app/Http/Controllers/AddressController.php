<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Address;
use App\AddressGeometry;
use App\Location;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formatted_address' => 'string|required',
            'place_id' => 'nullable|string|max:255',
            'plus_code' => 'string|required|max:255',
            'type' => 'string|required',
            'geometry' => 'nullable|string',
            'address_components' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }



        $data = collect($request->all())->toArray();

        $data = $this->parseGeometry($data);
        $data['user_id'] = Auth::user()->id;

        $result = Address::create($data);
        //obtain longitude and latitude if they werent set

        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function parseGeometry(array $data): array
    {
        $geometryData = json_decode($data['geometry']);
        if ($geometryData) {
            $location = Location::json($geometryData['location']);
            $nothEastBound = Location::json($geometryData['viewport']['northeast']);
            $southWestBound = Location::json($geometryData['viewport']['southwest']);
            $geometry = AddressGeometry::create(
                [
                    'location_id' => $location->id,
                    'northeast_location_id' => $nothEastBound->id,
                    'southwest_location_id' => $southWestBound->id,
                ]
            );
            $data['geometry_id'] = $geometry->id;
        }
        return $data;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:addresses,id',
            'formatted_address' => 'string|required',
            'place_id' => 'nullable|string|max:255',
            'plus_code' => 'string|required|max:255',
            'type' => 'string|required',
            'geometry' => 'nullable|string',
            'address_components' => 'nullable|boolean',
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
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = Address::paginate($length);
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
}
