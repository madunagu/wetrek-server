<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trek extends Model
{
    protected $fillable = ['name', 'start_address_id', 'end_address_id', 'direction', 'starting_at', 'user_id'];
    protected $with = ['picture', 'startAddress', 'endAddress'];

    public function locations()
    {
        return $this->belongsToMany('App\Location', 'location_trek', 'location_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'trek_user', 'user_id');
    }

    public function startAddress()
    {
        return $this->hasOne('App\Address', 'id', 'start_address_id');
    }

    public function endAddress()
    {
        return $this->hasOne('App\Address', 'id', 'end_address_id');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function picture()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'large' => 'https://picsum.photos/500',
            'medium' => 'https://picsum.photos/200',
            'small' => 'https://picsum.photos/100',
            'full' => 'https://picsum.photos/200',
            'user_id' => 1,
        ]);;
    }
}
