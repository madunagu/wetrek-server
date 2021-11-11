<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Address;
use App\Setting;

class SettingsController extends Controller
{
    public function set(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required',
            'value' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $user = Auth::user();
        $result = Setting::updateOrCreate(
            ['user_id' => $user->id, 'setting_id' => $data['id']],
            ['setting_value' => $data['value']]
        );
        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }



    public function updateGroup(Request $request)
    {
        //TODO: complete functionality
        $validator = Validator::make($request->all(), [
            'ids' => 'integer|required|exists:addresses,id',
            'values' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $data = collect($request->all())->toArray();

        $data['user_id'] = Auth::user()->id;
        $result = Setting::where('active', 1)
            ->where('destination', 'San Diego')
            ->update(['delayed' => 1]);
        //obtain longitude and latitude if they werent set
        $result = $result->update($data);
        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }
}
