<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
class ThreadsTest extends TestCase
{
    use RefreshDatabase;
    //use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        //Given we have a thread
        $this->thread = factory('App\Thread')->create();
    }
  /** @test */
    public function a_user_can_view_all_threads()
    {
        

        $response = $this->get('/threads')
            ->assertSee($this->thread->title);

        
    
    }
     /**
     * @test
     */
    public function a_user_can_read_a_single_thread()
    {
       

        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }
     /**
     * @test
     */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        //And that thread includes replies
        $this->get($this->thread->path())
            ->assertSee($reply->body);
        //When we visit a thread page
        //Then we should see the replies
    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_channel()
    {
       
       $channels = create('App\Channels');
       $threadInChannel = create('App\Thread', ['channels_id' => $channels->id]);
       $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channels->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);

        $ThreadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($ThreadNotByJohn->title);
    }
}
