@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    @include('navbar')


    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <!-- Step Start -->

        <div class="row mb-5">
            <div class="progress bg-transparent mb-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 70%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="6">
                        <a href="{{ route('bookings') }}" class="btn btn-warning">
                            <i class="fa fa-book"></i>
                            Booking
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="6">
                        <a href="{{route('passengers',['booking_id' => $booking_id])}}" class="btn btn-warning">
                            <i class="fa fa-user"></i>
                            Passengers
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="6">
                        <a href="{{ route('bookingDetail',['booking_id'=> $booking_id]) }}" class="btn btn-warning">
                            <i class="fa fa-flag"></i>
                            Finalize
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step End -->
        <div class="row g-4 ">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4>Booking Detail</h4>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" name="destination" class="form-control" id="destination" value="{{ $booking->destination }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" id="location" value="{{ $booking->location }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="pick_date_time" class="form-label">Pick Date Time</label>
                        <input type="text" name="pick_date_time" class="form-control" id="pick_date_time" value="{{ $booking->pick_date_time }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_type" class="form-label">Vehicle Type</label>
                        <input type="text" name="vehicle_type" class="form-control" id="vehicle_type" value="{{ $booking->vehicle_type }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="extras" class="form-label">Extras</label>
                        <input type="text" name="extras" class="form-control" id="extras" value="{{ $booking->extras }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="price" value="{{ $booking->price }}" disabled>
                    </div>
                    <h6>Passenger Details</h6>
                    @foreach ($booking->passengers as $passenger)
                    <hr>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $passenger->name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $passenger->phone_number }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="suitcase_number" class="form-label">Pick Date Time</label>
                        <input type="text" name="suitcase_number" class="form-control" id="suitcase_number" value="{{ $passenger->suitcase_number }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="flight_date_time" class="form-label">Flight Date Time</label>
                        <input type="text" name="flight_date_time" class="form-control" id="flight_date_time" value="{{ $passenger->flight_date_time }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="flight_number" class="form-label">Flight Number</label>
                        <input type="text" name="flight_number" class="form-control" id="flight_number" value="{{ $passenger->flight_number }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="flight_airline" class="form-label">Flight Airline</label>
                        <input type="text" name="flight_airline" class="form-control" id="flight_airline" value="{{ $passenger->flight_airline }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="flight_arriving_from" class="form-label">Flight Arriving From</label>
                        <input type="text" name="flight_arriving_from" class="form-control" id="flight_arriving_from" value="{{ $passenger->flight_arriving_from }}" disabled>
                    </div>
                    @endforeach

                    <a href="{{route('bookings')}}" class="btn btn-danger">Confirm</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
