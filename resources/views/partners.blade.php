@extends('welcome')
@section('content')
    <div class="col-12">
        <div class="rounded h-100 p-4">
            <h6 class="mb-4">Partners Data</h6>
            <a href="{{route('addPartners')}}" class="btn btn-primary">Add Partner</a>
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
                        @foreach ($data as $partner)
                            <tr>
                                <th scope="row">{{$partner->id}}</th>
                                <td>{{$partner->name}}</td>
                                <td>{{$partner->email}}</td>
                                <td>{{$partner->created_at}}</td>
                                <td>
                                    <a href="{{route('editPartners',['id'=>$partner->id])}}"><i class="fa fa-edit"></i>Edit</a>
                                    |
                                    <a href="{{route('deleteUsers',['id'=>$partner->id])}}"><i class="fa fa-trash"></i>Delete</a>
                                    |
                                    <a href="{{route('viewUserLogs',['user_id'=>$partner->id])}}"> <i class="fa fa-file"></i>View Logs</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
