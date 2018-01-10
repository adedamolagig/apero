<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
	/**
     * @test
     */
    use RefreshDatabase;

	protected $thread;

	public function setUp()
	{
		parent::setUp();

		$this->thread = factory('App\Thread')->create();
	}


    /** @test */
    function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

       // $this->assertEquals('/threads/'. $thread->channels->slug . '/' . $thread->id, $thread->path() );

        $this->assertEquals(
            "/threads/{$thread->channels->slug}/{$thread->id}", $thread->path()
        );
    }


    /**
     * @test
     */
    function a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /**
     * @test
     */
    function a_thread_has_replies()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
     

    /** @test */
    public function a_thread_can_add_a_reply()
    {
    	$this->thread->addReply([
    		'body' => 'Foobar',
    		'user_id' => 1
    	]);

    	$this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channels', $thread->channels);
    }   
}
