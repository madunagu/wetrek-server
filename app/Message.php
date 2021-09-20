<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Message extends Model
{
    use SearchableTrait;

    protected $fillable = ['message', 'sender_id', 'messagable_id', 'messagable_type'];
    protected $with = ['messagable'];

    function messagable()
    {
        return $this->morphTo('messagable');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
