<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{	
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_threa_receives_a_new_reply_that_is_not_by_the_current_user()
    {
    	$this->signIn();

    	$thread = create('App\Thread')->subscribe();
    	//before the reply is left, there were no notification
		$this->assertCount(0, auth()->user()->notifications);

		// Then, each time a reply is left
		$thread->addReply([
			'user_id' => auth()->id(),
			'body' => 'Some reply here'
		]);

		// a notification is prepared fot the user

		$this->assertCount(0, auth()->user()->fresh()->notifications);

		// Then, each time a reply is left
		$thread->addReply([
			'user_id' => create('App\User')->id,
			'body' => 'Some reply here'
		]);

		$this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test*/
    function a_user_can_fetch_their_unread_notifications()
    {
    	$this->signIn();

    	$thread = create('App\Thread')->subscribe();

    	$thread->addReply([
			'user_id' => auth()->id(),
			'body' => 'Some reply here'
		]);

    	$user = auth()->user();

		$repsonse = $this->getJson("/profiles/{$user->name}/notifications/")->json();

    	$this->assertCount(0, $repsonse);
    }
    function test_a_user_can_make_a_notification_as_read()
    {
    	$this->signIn();

    	$thread = create('App\Thread')->subscribe();

    	$thread->addReply([
			'user_id' => create('App\User')->id,
			'body' => 'Some reply here'
		]);

		$user = auth()->user();

		$this->assertCount(1, $user->unreadNotifications);

		$notificationsId = $user->unreadNotifications->first()->id;

		$this->delete("/profiles/{$user->name}/notifications/{$notificationsId}");

		$this->assertCount(0, $user->fresh()->unreadNotifications);
    }

}
