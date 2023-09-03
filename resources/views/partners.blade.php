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
                                <td>{{date('d/m/Y H:m:i', strtotime($partner->created_at))}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('editPartners',['id'=>$partner->id])}}"> <i class="fa fa-edit mr-2"></i>Edit</a>
                                            <a class="dropdown-item" href="{{route('deleteUsers',['id'=>$partner->id])}}" onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};" > <i class="fa fa-trash mr-2"></i>Delete</a>
                                            <a class="dropdown-item" href="{{route('viewUserLogs',['user_id'=>$partner->id])}}"> <i class="fa fa-file mr-2"></i>View Logs</a>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
