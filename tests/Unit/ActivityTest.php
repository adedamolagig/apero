<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
use illuminate\Foundation\Testing\DatabaseMigrations;


class ActivityTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_records_activity_when_a_thread_is_created()
	{
		//Sign a user in 
		$this->signIn();

		//if we create a thread and persist it
		$thread = create('App\Thread');

		//i expect that there should be activity
		$this->assertDatabaseHas('activities', [
			'type' => 'created_thread',
			'user_id' => auth()->id(),
			'subject_id' => $thread->id,
			'subject_type' => 'App\Thread'
		]);

		$activity = Activity::first();

		$this->assertEquals($activity->subject->id, $thread->id);

	}

	/** @test */
	function it_records_activity_when_a_reply_is_created()
	{
		//Sign a user in 
		$this->signIn();

		//if we create a reply and persist it
		$reply = create('App\Reply');

		//we expect to have two records in the database
		$this->assertEquals(2, Activity::count());
		
	}
}