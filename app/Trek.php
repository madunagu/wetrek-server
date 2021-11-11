<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Carbon\Carbon;

class Trek extends Model
{
    use SearchableTrait;

    protected $fillable = ['name', 'description', 'start_address_id', 'end_address_id', 'direction', 'starting_at', 'user_id'];
    protected $with = ['picture', 'startAddress', 'endAddress','users'];
    protected $casts = ['start_address_id' => 'integer', 'end_address_id' => 'integer'];

    public function locations()
    {
        return $this->belongsToMany('App\Location', 'location_trek', 'location_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'trek_user', 'user_id', 'trek_id');
    }

    public function startAddress()
    {
        return $this->hasOne('App\Address', 'id', 'start_address_id');
    }

    public function endAddress()
    {
        return $this->hasOne('App\Address', 'id', 'end_address_id');
    }

    public function pictures()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function picture()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'id' => 0,
            'large' => 'https://picsum.photos/500',
            'medium' => 'https://picsum.photos/200',
            'small' => 'https://picsum.photos/100',
            'full' => 'https://picsum.photos/200',
            'user_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),
        ]);;
    }

    protected $searchable = [
        'columns' => [
            'treks.description' => 10,
            'treks.name' => 10,
            'treks.direction' => 2,
            // 'users.email' => 5,
            // 'posts.title' => 2,
            // 'posts.body' => 1,
        ],
        // 'joins' => [
        //     'posts' => ['users.id','posts.user_id'],
        // ],
    ];
}
