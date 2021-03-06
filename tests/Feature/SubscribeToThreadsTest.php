<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
	use DatabaseMigrations;


	/** @test */
	public function a_user_can_subscribe_to_threads()
	{
		//Given a user is signed in 
		$this->signIn();

		// Given we have a thread
		$thread = create('App\Thread');

		// And the user subscribes to the thread or hits the end point for subscriptions
		$this->post($thread->path() . '/subscriptions');

		$this->assertCount(1, $thread->fresh()->subscriptions);
		
	}

	/** @test */
	public function a_user_can_unsubscribe_from_threads()
	{
		$this->signIn();

		// Given we have a thread
		$thread = create('App\Thread');

		$thread->subscribe();

		// An the user subscribes to the thread
		$this->delete($thread->path() . '/subscriptions');

		$this->assertCount(0, $thread->subscriptions);
	}
}