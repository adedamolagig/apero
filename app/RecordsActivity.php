<?php

namespace App;

trait RecordsActivity
{

	protected static function bootRecordsActivity()
	{
		static::created(function ($thread){
           $thread->recordActivity('created'); 
        });
	}
	
	protected function recordActivity($event)
    {
    	$this->activity()->create([
    			'user_id' => auth()->id(),
    			'type' => $this->getActivityType($event)
    		]);

        // Activity::create([
        //     'type' => $this->getActivityType($event),
        //     'user_id' => auth()->id(),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);
    }

    public function activity()
    {
    	return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event): string
    {
       $type = strtolower((new \ReflectionClass($this))->getShortName());

       return "{$event}_{$type}";
       // return $event . '_' . $type;
    }
}