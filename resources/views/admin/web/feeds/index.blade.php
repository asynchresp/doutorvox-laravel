
@extends('template')

@section('content')
    <h1>Blog - Admin</h1>

    <a href="{{route($baseRoute.'.create')}}" class="btn btn-success">Create</a>
    <br /><br />

    <table class="table">
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Action</td>
        </tr>

        @foreach($data as $model)
            <tr>
                <td>{{$model->id}}</td>
                <td>{{$model->url}}</td>
                <td><a href="{{route($baseRoute.'.edit', ['id' => $model->id])}}" class="btn btn-default">Edit</a>
                    <a href="{{route($baseRoute.'.destroy', ['id' => $model->id])}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach

    </table>
    {!!  $data->render() !!}

@endsection