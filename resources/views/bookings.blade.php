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
                    <h6 class="mb-4">Booking Data</h6>
                    <a href="{{route('addBooking')}}" class="btn btn-primary">Create Booking</a>
                    <div class="table-responsive">
                        <table class="table  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Pick Date</th>
                                    <th scope="col">Vehicle Type</th>
                                    <th scope="col">Extras</th>
                                    <th scope="col">Passengers</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{$booking->id}}</td>
                                        <td>{{$booking->destination}}</td>
                                        <td>{{$booking->location}}</td>
                                        <td>{{$booking->pick_date_time}}</td>
                                        <td>{{$booking->vehicle_type}}</td>
                                        <td>{{$booking->extras}}</td>
                                        <td>{{$booking->passengers->count()}}</td>
                                        <td>
                                            <a href="{{route('passengers',['booking_id'=>$booking->id])}}"> <i class="fa fa-user"></i>Passengers</a>
                                            |
                                            <a href="{{route('editBooking',['id'=>$booking->id])}}"> <i class="fa fa-edit"></i>Edit</a>
                                            |
                                            <a href="{{route('deleteBooking',['id'=>$booking->id])}}"> <i class="fa fa-trash"></i>Delete</a>
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

    <!-- Content End -->


@endsection
