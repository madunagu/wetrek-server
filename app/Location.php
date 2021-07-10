<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['lon', 'lat'];

    static function json($data):Location{
        return Location::create([
            'lon'=>$data['lon'],
            'lat'=>$data['lat'],
        ]);
    }
}
