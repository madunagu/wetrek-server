<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'formatted_address', 'place_id',
        'geometry_id', 'type',
        'plus_code', 'user_id',
    ];
}
