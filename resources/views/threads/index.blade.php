@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             @forelse ($threads as $thread)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">    
                            <h4 class="flex">
                                <a href="{{ $thread->path() }}">
                                    {{ $thread->title }}
                                </a>    
                            </h4>
                            

                            <a href=" {{ $thread->path() }} ">
                                <strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong>
                            </a>
                        </div>

                    </div>

                    <div class="panel-body">
                       <div class="panel-body">
                            {!! nl2br($thread->body) !!} 
                        </div>
         
                    </div>
                </div>

            @empty
            <p>There no threads on this channel at this time... </p>
            @endforelse

            {{$threads->links()}}
        </div>
    </div>
</div>
@endsection

