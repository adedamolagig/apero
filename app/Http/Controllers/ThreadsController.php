<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Channels;
use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    /** ThreadsController constructor */

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @param Channels $channels 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channels $channels, ThreadFilters $filters)
    {

        $threads = $this->getThreads($channels, $filters);

       

       if(request()->wantsJson()){
        return $threads;
       }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channels_id' => 'required|exists:channels,id'
       ]); 
       $thread = Thread::create([
            'user_id' => auth()->id(),
            'channels_id' => request('channels_id'),
            'title' => request('title'),
            'body' => request('body')
       ]);

       return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @param $channeId
     * @return \Illuminate\Http\Response
     */
    public function show($channels, Thread $thread)
    {
        //$threads = Thread::latest()->get();

        
        return view('threads.show', [

            'thread' => $thread,
            'replies' => $thread->replies()->paginate(30 ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channels, Thread $thread)
    {
        if($thread->user_id != auth()->id()){
            if(request()->wantsJson()){
                return response(['status' => 'Permission Denied'], 403); 
            }

            return redirect('/login');
        }
        
        $thread->delete();

        if (request()->wantsJson()){
            return response([], 204);
        }

        return redirect('/threads');
    }

    public function getThreads(Channels $channels, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if($channels->exists){
            $threads->where('channels_id', $channels->id);
        }

       

        return $threads->get();

    }


}
