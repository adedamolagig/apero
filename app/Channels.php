<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    //

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function threads()
    {
    	return $this->hasMany(Thread::class);
    }
}

