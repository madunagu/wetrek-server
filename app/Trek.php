<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trek extends Model
{
    protected $fillable = ['title', 'start_address_id', 'end_address_id', 'directions', 'starting_at', 'user_id'];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'trek_user', 'user_id');
    }
}
