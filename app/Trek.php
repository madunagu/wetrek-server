<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trek extends Model
{
    protected $fillable = ['address1','address2','country','state','city','postal_code','name','longitude','latitude','user_id'];

    public function start_address()
    {
        return $this->belongsTo('App\Address', 'start_address_id');
    }

    public function end_address()
    {
        return $this->belongsTo('App\Address', 'end_address_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'trek_user','user_id');
    }
}
