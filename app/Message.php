<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Message extends Model
{
    use SearchableTrait;

    protected $fillable = ['message', 'sender_id', 'messagable_id', 'messagable_type','grouper'];
    protected $with = ['messagable', 'sender'];

    function messagable()
    {
        return $this->morphTo('messagable');
    }

    function sender()
    {
        return $this->hasOne(User::class,'id','sender_id');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
