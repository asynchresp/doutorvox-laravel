
@extends('template')

@section('content')
    <h1>Create new Feed</h1>

    @if($errors->any())

        <ul class="alert">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>

    @endif
    {!! Form::open(['route' => 'admin.web.feeds.store', 'method' => 'post']) !!}

    @include('admin.web.feeds._form')

    <div class="form-group">
        {!! Form::submit('Create Feed',['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection