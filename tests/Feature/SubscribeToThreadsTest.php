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

		$this->signIn();

		// Given we have a thread
		$thread = create('App\Thread');

		// An the user subscribes to the thread
		$this->post($thread->path() . '/subscriptions');

		$this->assertCount(1, $thread->subscriptions);
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