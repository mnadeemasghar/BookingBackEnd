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
                    <h6 class="mb-4">Booking Data</h6>
                    @if (isset($for_partner) && $for_partner)
                        <a href="{{route('addBooking')}}" class="btn btn-primary">Create Booking</a>
                    @endif
                    <div class="table-responsive">
                        <table class="table  table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Drop Off</th>
                                    <th scope="col">Pick Up</th>
                                    <th scope="col">Pick Date</th>
                                    <th scope="col">Vehicle Type</th>
                                    <th scope="col">Extras</th>
                                    <th scope="col">Driver ID</th>
                                    <th scope="col">Driver Name</th>
                                    <th scope="col">Passengers</th>
                                    @if ($role == 'Admin' || $role == 'Partner')
                                    <th scope="col">Price</th>
                                    <th scope="col">Rejection</th>
                                    @endif
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{$booking->booking_id}}</td>
                                        <td>{{$booking->destination}}</td>
                                        <td>{{$booking->location}}</td>
                                        <td>{{$booking->pick_date_time}}</td>
                                        <td>{{$booking->vehicle_type}}</td>
                                        <td>{{$booking->extras}}</td>
                                        <td>{{$booking->driver_id}}</td>
                                        <td>{{$booking->driver[0]->name ?? ""}}</td>
                                        <td>{{$booking->passenger_nos}}</td>
                                        @if ($role == 'Admin' || $role == 'Partner')
                                        <td>{{ $booking->currency ?? "" }} {{ $booking->price ?? ""}}</td>
                                        <td>{{$booking->reason ?? ""}}</td>
                                        @endif
                                        <td>{{$booking->status}}</td>
                                        <td>
                                            @if ($role == "Partner")
                                                <a href="{{route('viewLogs',['booking_id' => $booking->id])}}">
                                                    <i class="fa fa-user"></i>
                                                    Logs
                                                </a>
                                                <br>
                                                <a href="{{route('passengers',['booking_id' => $booking->id])}}">
                                                    <i class="fa fa-user"></i>
                                                    Passengers
                                                </a>
                                                <br>
                                                <a href="{{route('editBooking',['id' => $booking->id])}}">
                                                    <i class="fa fa-edit"></i>
                                                    Edit
                                                </a>
                                                <br>
                                                <a href="{{route('deleteBooking',['id' => $booking->id])}}">
                                                    <i class="fa fa-trash"></i>
                                                    Delete
                                                </a>
                                            @elseif ($role == "Admin")
                                                <a href="{{route('viewLogs',['booking_id' => $booking->id])}}">
                                                    <i class="fa fa-user"></i>
                                                    Logs
                                                </a>
                                                <br>
                                                <a href="{{route('passengers',['booking_id' => $booking->id])}}">
                                                    <i class="fa fa-user"></i>
                                                    Passengers
                                                </a>
                                                <br>
                                                <a href="{{route('editBooking',['id' => $booking->id])}}">
                                                    <i class="fa fa-edit"></i>
                                                    Edit
                                                </a>
                                                <br>
                                                <a href="{{route('deleteBooking',['id' => $booking->id])}}">
                                                    <i class="fa fa-trash"></i>
                                                    Delete
                                                </a>
                                                <br>
                                                @if ($booking->status == "pending")
                                                    <a  class="text-success" href="{{route('acceptBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Aceept
                                                    </a>
                                                    <br>
                                                    <a class="text-danger" href="{{route('rejectBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Reject
                                                    </a>
                                                    @elseif ($booking->status == "accepted")
                                                        <a href="{{route('assignDriver',['booking_id' => $booking->id])}}">
                                                            <i class="fa fa-plus"></i>
                                                            Assign
                                                        </a>
                                                @elseif ($booking->status == "assigned")
                                                    <a href="{{route('assignDriver',['booking_id' => $booking->id])}}">
                                                        <i class="fa fa-plus"></i>
                                                        Assign
                                                    </a>
                                                @endif
                                            @elseif ($role == "Driver")
                                                <a href="{{route('viewPassengers',['booking_id' => $booking->id])}}">
                                                    <i class="fa fa-user"></i>
                                                    Passengers
                                                </a>
                                                <br>
                                                @if ($booking->status == "assigned")
                                                    <a href="{{route('onTheWayBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        On the Way
                                                    </a>
                                                @elseif ($booking->status == "ontheway")
                                                    <a href="{{route('arriveBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Arrived
                                                    </a>
                                                @elseif ($booking->status == "arrived")
                                                    <a class="text-success" href="{{route('onboardBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Onboard
                                                    </a>
                                                    <a class="text-danger" href="{{route('noshowBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Customer not Shown
                                                    </a>
                                                @elseif ($booking->status == "onboard")
                                                    <a href="{{route('completeBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Complete
                                                    </a>
                                                    <a href="{{route('addStopBooking',['id' => $booking->id])}}">
                                                        <i class="fa fa-book"></i>
                                                        Stops
                                                    </a>
                                                @endif
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

    <!-- Content End -->


@endsection
