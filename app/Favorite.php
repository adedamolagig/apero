<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	use RecordsActivity;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Fetch the associated subject for the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorited()
    {
    	return $this->morphTo();
    }
}
