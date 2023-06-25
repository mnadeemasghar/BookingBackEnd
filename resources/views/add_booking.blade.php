@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="{{route('home')}}" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
            <input class="form-control bg-dark border-0" type="search" placeholder="Search">
        </form>
        <div class="navbar-nav align-items-center ms-auto">
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
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
                    <h6 class="mb-4">Add Booking</h6>
                    <form action="{{ isset($edit) ? route('updateBooking',['id'=> $booking->id]) : route('storeBooking') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" name="destination" class="form-control" value="{{ isset($edit) ? $booking->destination:'' }}" placeholder="City Center, train station. Etc. hotel or property" id="destination">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ isset($edit) ? $booking->location:'' }}" id="location">
                        </div>
                        <div class="mb-3">
                            <label for="pick_date_time" class="form-label">Pick Date Time</label>
                            <input type="datetime-local" name="pick_date_time" value="{{ isset($edit) ? $booking->pick_date_time:'' }}" class="form-control" id="pick_date_time">
                        </div>
                        <div class="mb-3">
                            <label for="vehicle_type" class="form-label">Vehicle Type</label>
                            <select name="vehicle_type" class="form-control" id="vehicle_type">
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->type }}" {{ isset($booking) && $booking->vehicle_type == $vehicleType->type ? "selected":"" }}>{{ $vehicleType->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="extras" class="form-label">Extras</label>
                            <input type="text" name="extras" class="form-control" value="{{ isset($edit) ? $booking->extras:'' }}" placeholder="Wheelchair, Baby seat, child seat with additional cost" id="extras">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($edit) ? 'Update Booking':'Add Booking' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table End -->

    <!-- Content End -->


@endsection
