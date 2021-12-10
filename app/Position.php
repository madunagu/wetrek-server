<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'longitude',
        'latitude',
        'timestamp',
        'accuracy',
        'altitude',
        'heading',
        'speed',
        'speed_accuracy',
        'user_id'
    ];
}
