<?php

namespace Tests\Features;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ChannelTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function a_channel_consists_of_threads()
	{
		$channels = create('App\Channels');
		$threads = create('App\Thread', ['channels_id' => $channels->id]);

		$this->assertTrue($channels->threads->contains($threads));


	} 
}