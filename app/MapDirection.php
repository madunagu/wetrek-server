<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapDirection extends Model
{
    protected $table = 'directions';
    protected $fillable = ['trek_id','directions_data'];
}
