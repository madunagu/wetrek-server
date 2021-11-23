<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ['picture', 'location', 'setting'];


    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id')->whereKeyNot(1);
    }

    public function isFollowing()
    {
        return $this->belongsToMany('App\User', 'followers', 'following_id', 'follower_id')->whereKeyNot(1);
    }


    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'following_id', 'follower_id')->whereKeyNot(1);
    }

    public function picture()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'large' => 'https://picsum.photos/500',
            'medium' => 'https://picsum.photos/200',
            'small' => 'https://picsum.photos/100',
            'full' => 'https://picsum.photos/200',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' =>  Carbon::now(),
        ]);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function locations()
    {
        return $this->hasMany('App\Location')->take(1);
    }

    public function location()
    {
        return $this->hasOne('App\Location')->withDefault([
            'lat' => 1,
            'lng' => 1,
            'user_id' => 1,
        ])->take(1);
    }

    public function setting()
    {
        return $this->hasMany('App\Setting');
    }

    public function treks()
    {
        return $this->belongsToMany('App\Trek', 'trek_user', 'user_id', 'trek_id');
    }

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.email' => 5,
            // 'users.email' => 5,
            // 'posts.title' => 2,
            // 'posts.body' => 1,
        ],
        // 'joins' => [
        //     'posts' => ['users.id','posts.user_id'],
        // ],
    ];
}
