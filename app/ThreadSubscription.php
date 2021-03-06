<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
  //ThreadSubscription model
    protected $guarded = [];

  	public function user()
  	{
  		return $this->belongsTo('App\User');
  	}

  	public function thread()
  	{
  		return $this->belongsTo(Thread::class);
  	}

  	public function notify($reply)
  	{
  		$this->user->notify(new ThreadWasUpdated($this->thread, $reply));
  	}
}
