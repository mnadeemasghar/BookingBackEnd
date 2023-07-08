@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    @include('navbar')


    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            @if(session()->has('msg'))
                <div class="alert alert-info">
                    {{ session()->get('msg') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <h6 class="mb-4">{{ isset($edit) ? "Update Vehicle":"Add Vehicle"}}</h6>
            <form action="{{ isset($edit) ? route('updateVehicle',['id'=>$vehicle->id]) : route('storeVehicle')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" id="type" value="{{isset($edit) ? $vehicle->type:''}}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($edit) ? "Update Vehicle":"Add Vehicle" }}</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
