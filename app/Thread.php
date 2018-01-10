<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });
    }

    public function path()
    {
    	return "/threads/{$this->channels->slug}/{$this->id}";
        //same as above, just some refactoring
        //return '/threads/'. $this->channels->slug. '/' .$this->id;
    }

    public function replies()
    {
    	return $this->hasMany('App\Reply');
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }


    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function channels()
    {
        return $this->belongsTo('App\Channels');
    }

    public function addReply($reply)
    {
    	$this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query); 
    }
}
