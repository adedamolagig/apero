@extends('layouts.app')

@section('content')
<thread-view inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                 <a href="/profiles/{{$thread->owner->name}}">{{ $thread->owner->name }}</a> posted:
                                {{ $thread->title }}
                            </span>

                            @can('update', $thread)
                            <form action=" {{ $thread->path() }} " method="POST">
                                {{ csrf_field() }}

                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-danger ">Delete Thoughts </button>
                            </form>
                            @endcan

                        </div>
                       
                    </div>

                    <div class="panel-body">
                       {!! nl2br($thread->body) !!} 
                    
                    </div>
                </div>

            


                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

               

                @if(auth()->check())
                    <form method="POST" action="{{ $thread->path(). '/replies'}}">
                    {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="add a reply" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Drop my reply</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> or <a href="{{ route('register')}}">sign up</a> to participate in the forum</p>
                @endif
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-body">
                        This Thread was published {{ $thread->created_at->diffForHumans()}} by 
                        <a href="#"> {{$thread->owner->name}}</a>, and currently has {{ $thread->replies_count }} {{str_plural('reply', $thread->replies_count) }}
                    </div>

                    <subscribe-button></subscribe-button>
                </div>
            </div>
        </div>
    </div>
</thread-view>

@endsection
