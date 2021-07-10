<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressGeometry extends Model
{
    protected $fillable = [
        'location_id', 'northeast_location_id',
        'southwest_location_id'
    ];
}
