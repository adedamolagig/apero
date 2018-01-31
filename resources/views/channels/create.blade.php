@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Channel</div>

                <div class="panel-body">
                    <form method="POST" action=" {{ route('CreateChannels') }} ">
                        {{csrf_field()}}


                        <!-- <div class="form-group">
                            <label for="channels_id">Choose a Channel:</label>
                            <select name="channels_id" id="channels_id" class="form-control" required>
                                <option value="">Choose one...</option>

                                @foreach($channels as $channel)
                                    <option value=" {{ $channel->id }} " {{ old('channel_id') == $channel->id ? 'selected' : '' }} >
                                        {{ $channel->name }}                                        
                                    </option>

                                @endforeach
                            
                            </select>
                        </div> -->


                        <div class="form-group">
                            <label for="name">Name of Channel:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>                          
                        </div>


                        <div class="form-group">
                            <label for="slug">Slug:</label>
                            <textarea name="slug" id="slug" class="form-control" rows="15" required>{{ old('slug') }}</textarea>
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary">POST</button>
                        </div>
                        

                        @if(count($errors))
                        <ul class="alert alert-danger">
                            
                            @foreach($errors ->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>

                        @endif

                    </form>

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
