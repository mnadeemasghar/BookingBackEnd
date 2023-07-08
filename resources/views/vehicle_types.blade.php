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
                        <h6 class="mb-4">Vehicle Types</h6>
                        <a href="{{route('addVehicle')}}" class="btn btn-primary">Add Vehicle</a>
                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $vehicle_type)
                                        <tr>
                                            <th scope="row">{{$vehicle_type->id}}</th>
                                            <td>{{$vehicle_type->type}}</td>
                                            <td>
                                                <a href="{{route('editVehicle',['id'=>$vehicle_type->id])}}"><i class="fa fa-edit"></i>Edit</a>
                                                |
                                                <a href="{{route('deleteVehicle',['id'=>$vehicle_type->id])}}"><i class="fa fa-trash"></i>Delete</a>
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
