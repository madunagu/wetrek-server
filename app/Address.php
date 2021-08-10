<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description', 'place_id',
        'reference', 'geometry',
        'types', 'user_id',
    ];
}
