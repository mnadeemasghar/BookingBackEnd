@extends('welcome')
@section('content')

    <!-- Content Start -->
    <div class="content">
        @include('navbar')


        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-secondary rounded h-100 p-4">
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
                                                <a href="{{route('editPartners',['id'=>$partner->id])}}"><i class="fa fa-edit"></i></a>
                                                |
                                                <a href="{{route('deleteUsers',['id'=>$partner->id])}}"><i class="fa fa-trash"></i></a>
                                                |
                                                <a href="{{route('viewUserLogs',['user_id'=>$partner->id])}}"> <i class="fa fa-file"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table End -->



@endsection
