@extends('layouts.app')

@section('content')




	@foreach($channels as $channel)
	    <p>{{ $channel->name }}</p>
	@endforeach

@endsection