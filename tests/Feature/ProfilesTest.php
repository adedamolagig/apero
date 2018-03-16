<?php

namespace Tests\feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function test_a_user_has_a_profile()
	{
		$user = create('App\User');

		$this->get("/profiles/{$user->name}")
			->assertSee($user->name);
	}

	/** @test */

	function profiles_display_all_threads_created_by_the_associated_user()
	{
		$user = create('App\User');
		
		$thread = create('App\Thread', ['user_id' => $user->id]);

		$this->get("/profiles/{$user->name}")	
			->assertSee($thread->title)
			->assertSee($thread->body);
	}
}