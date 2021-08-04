<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id')->whereKeyNot(1);
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'following_id', 'follower_id');
    }

    public function picture()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function locations()
    {
        return $this->hasMany('App\Location')->take(1);
    }

    public function treks()
    {
        return $this->belongsToMany('App\Trek', 'trek_user', 'user_id', 'trek_id');
    }
}
