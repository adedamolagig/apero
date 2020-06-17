<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
use Carbon\Carbon;
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

	/** @test */
	function it_fetches_a_feed_for_any_user()
	{
		//Given we have a thread
		$this->signIn();

		create('App\Thread', ['user_id' => auth()->id()], 2);
		//And another thread from a week ago

		// create('App\Thread', [
		// 		'user_id' => auth()->id(),
		// 		'created_at' => Carbon::now()->subWeek()
		// 	]); ------------all of these is been replaced with 2 on line 58 above

		auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

		//When we fetch their feed,
		$feed = Activity::feed(auth()->user());

		//Then, it should be returned in the proper format.\
		$this->assertTrue($feed->keys()->contains(
				Carbon::now()->format('Y-m-d')
			));

			$this->assertTrue($feed->keys()->contains(
			Carbon::now()->format('Y-m-d')
		));
	}
}