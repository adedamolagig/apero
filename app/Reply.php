<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity; 

    /**
     * Don't auto-apply mass assignment protection
     *
     * @var array
     */

	protected $guarded = [];

    /**
     * eager load this relationship for every single query
     *
     */

    protected $with = ['owner', 'favorites'];


    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

   
}
