<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Address extends Model
{
    use SoftDeletes, SearchableTrait;

    protected $fillable = [
        'description', 'place_id',
        'reference', 'geometry',
        'types', 'user_id',
    ];
    protected $searchable = [
        'columns' => [
            'addresses.description' => 10,
        ],
    ];

    public function treks()
    {
        return $this->hasMany('App\Trek','start_address_id')->take(1);
    }
}
