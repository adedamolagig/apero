@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             @foreach ($threads as $thread)
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                       
                        	<article>
                                <div class="level">
                                
                                    <h4 class="flex">
                                        <a href="{{ $thread->path() }}">
                                            {{ $thread->title }}
                                        </a>

                                         <div class="panel-body">
                                            {{ $thread->body }} 
                                        </div>
                                    </h4>
                                    

                                    <a href=" {{ $thread->path() }} ">
                                        <strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong>
                                    </a>
                                </div>
                        	</article>

                        	<hr>
                    </div>
                </div>
             @endforeach
        </div>
    </div>
</div>
@endsection

