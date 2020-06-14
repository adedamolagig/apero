<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_may_not_create_threads()
    {

        $this->withExceptionHandling();
                
        $this->get('/threads/create')
                ->assertRedirect('/login');

                
        $this->post('/threads')
                ->assertRedirect('/login');
    	// $this->expectException('Illuminate\Auth\AuthenticationException');
    	// $thread = make('App\Thread'); 

    	// $this->post('/threads', $thread->toArray());
    }

    // /** @test */
    // function guest_cannot_see_the_create_thread_page()
    // {

    // }

    /** @test */

    function an_authenticated_can_create_new_forum_threads()
    {
    	//Given we have a signed in user
    	//$this->actingAs(create('App\User'));
        $this->signIn();


    	//When we hit the endpoint to make a new thread
    	$thread = make('App\Thread'); 

        //save to database
    	$response = $this->post('/threads', $thread->toArray());

    	//then we visit the thread page
    	$this->get($response->headers->get('Location'))

    	//We should see the new thread
    		->assertSee($thread->title)
    		->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
     
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');


        
        //     ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channels', 2)->create();

        $this->publishThread(['channels_id' => null])
            ->assertSessionHasErrors('channels_id');

        $this->publishThread(['channels_id' => 999])
            ->assertSessionHasErrors('channels_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        //Given we have a thread 
        $thread = create('App\Thread');

        //When we submit a test to delete a thread
        $this->delete($thread->path())

        //Its not going to work, it just redirects
                ->assertRedirect('/login');

        //However, if we are signed in and 
        $this->signIn();

        //perform a delete function, it should still redirect
        $this->delete($thread->path())->assertRedirect('/login');
    }



    /** @test */
    public function authorized_users_can_delete_a_thread()
    {
        //Given that we have a signed in user
        $this->signIn();

        //Create a thread that is owned by the user(['user_id' => auth()->id])
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        //Create a reply that is owned by the user(['user_id' => auth()->id])
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        //When they try to delete the thread
        $response = $this->json('DELETE', $thread->path());

        //Assert 204 response 
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id] );
        $this->assertDatabaseMissing('replies', ['id' => $reply->id] );

       
    }


    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

       

        return $this->post('/threads', $thread->toArray()); 
    }
}
