<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\notifications\ThreadWasUpdated;

class Thread extends Model
{
    use RecordsActivity;
    
    protected $guarded = [];

    protected $with = ['owner', 'channels'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        static::deleting(function ($thread){
            $thread->replies()->delete();
        }); 
        // static::addGlobalScope('owner', function($builder){
        //     $builder->with('owner');
        // });

        
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
        /** this line of code is replaced with eagerloading on Reply model
         * using the
         * @protected $with = [] function
            ->withCount('favorites')
            ->with('owner');
            
        */
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
    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     * @return Model
     */
    public function addReply($reply)
    {
    	$reply = $this->replies()->create($reply);
        // Prepare notifications for all subscribers.

        $this->subscriptions
            ->filter(function ($sub) use ($reply){

            return $sub->user_id != $reply->user_id;
        })
        ->each->notify($reply);
        // foreach ($this->subscriptions as $subscription) {
        //     if ($subscription->user_id != $reply->user_id) {
                
        //     }  
        // }

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query); 
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {

        $this->subscriptions()->create([

            // use the userId provided otherwise fallback to checking the authenticated user
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        //find all subscriptions to the thread(yours and everyother) and delete subscriptions with your own userId
        return $this->subscriptions()
                ->where('user_id', auth()->id())
                ->exists();
    }

    public function isSubscribedTo()
    {
        return $this->subscriptions()
                ->where('user_id', auth()->id())
                ->exists();
    }
}
