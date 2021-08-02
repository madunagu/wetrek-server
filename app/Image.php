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


    public function imageable()
    {
        return $this->morphTo();
    }
}
