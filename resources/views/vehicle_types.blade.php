@extends('welcome')
@section('content')
    <div class="col-12">
        <div class="rounded h-100 p-4">
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
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('editVehicle',['id'=>$vehicle_type->id])}}"> <i class="fa fa-edit mr-2"></i>Edit</a>
                                            <a class="dropdown-item" href="{{route('deleteVehicle',['id'=>$vehicle_type->id])}}" onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};" > <i class="fa fa-trash mr-2"></i>Delete</a>
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
