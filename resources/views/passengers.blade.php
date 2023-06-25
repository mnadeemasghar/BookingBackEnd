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
                        <h6 class="mb-4">Passengers Data</h6>
                        @if (!isset($view))
                            <a href="{{route('addPassenger',['booking_id' => $booking_id])}}" class="btn btn-primary">Add Passenger</a>
                        @endif
                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Suitcase No.</th>
                                        <th scope="col">Flight Date</th>
                                        <th scope="col">Flight No.</th>
                                        <th scope="col">Airline</th>
                                        <th scope="col">Arriving From</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($passengers as $passenger)
                                        <tr>
                                            <td>{{$passenger->id}}</td>
                                            <td>{{$passenger->booking_id}}</td>
                                            <td>{{$passenger->name}}</td>
                                            <td>{{$passenger->phone_number}}</td>
                                            <td>{{$passenger->suitcase_number}}</td>
                                            <td>{{$passenger->flight_date_time}}</td>
                                            <td>{{$passenger->flight_number}}</td>
                                            <td>{{$passenger->flight_airline}}</td>
                                            <td>{{$passenger->flight_arriving_from}}</td>
                                            <td>
                                                @if (!isset($view))
                                                    <a href="{{route('editPassenger',['id'=>$passenger->id])}}"> <i class="fa fa-edit"></i>Edit</a>
                                                    |
                                                    <a href="{{route('deletePassenger',['id'=>$passenger->id])}}"> <i class="fa fa-trash"></i>Delete</a>
                                                @endif

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

