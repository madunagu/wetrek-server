<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'full',
        'large',
        'medium',
        'small',
        'user_id',
        'imageable_id',
        'imageable_type'
    ];

    protected $hidden = ['imageable_type','imageable_id'];


    public function imageable()
    {
        return $this->morphTo();
    }
}
