@extends('welcome')
@section('content')
<div class="col-12">
    <div class="rounded h-100 p-4">
        @if(session()->has('msg'))
            <div class="alert alert-info">
                {{ session()->get('msg') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <h6 class="mb-4">Drivers Data</h6>
        <a href="{{route('addDrivers')}}" class="btn btn-primary">Add Driver</a>
        <div class="table-responsive">
            <table class="table  table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $driver)
                        <tr>
                            <th scope="row">{{$driver->id}}</th>
                            <td>{{$driver->name}}</td>
                            <td>{{$driver->email}}</td>
                            <td>{{$driver->created_at}}</td>
                            <td>
                                <a href="{{route('editDrivers',['id'=>$driver->id])}}"> <i class="fa fa-edit"></i>Edit</a>
                                |
                                <a href="{{route('deleteUsers',['id'=>$driver->id])}}"> <i class="fa fa-trash"></i>Delete</a>
                                |
                                <a href="{{route('viewUserLogs',['user_id'=>$driver->id])}}"> <i class="fa fa-file"></i>View Logs</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

