@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    @include('navbar')


    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <!-- Step Start -->

            <div class="row mb-5">
                <div class="progress bg-transparent mb-1">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 33%" aria-valuemin="0" aria-valuemax="100"></div>
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
            @if(session()->has('msg'))
                <div class="alert alert-info">
                    {{ session()->get('msg') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <h6 class="mb-4">{{ isset($edit) ? "Update Passenger":"Add Passenger"}}</h6>
            <form action="{{ isset($edit) ? route('updatePassenger',['id'=>$passenger->id]) : route('storePassenger',['booking_id'=>$booking_id])}}" method="POST">
                @csrf
                <div class="mb-3 d-none">
                    <label for="booking_id" class="form-label">Booking ID</label>
                    <input type="text" name="booking_id" class="form-control" id="booking_id" value="{{isset($edit) ? $passenger->booking_id:$booking_id}}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{isset($edit) ? $passenger->name:''}}">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{isset($edit) ? $passenger->phone_number:''}}">
                </div>
                <div class="mb-3">
                    <label for="suitcase_number" class="form-label">Suitcase Number</label>
                    <input type="text" name="suitcase_number" class="form-control" id="suitcase_number" value="{{isset($edit) ? $passenger->suitcase_number:''}}">
                </div>
                <div class="mb-3">
                    <label for="flight_date_time" class="form-label">Flight Date Time</label>
                    <input type="datetime-local" name="flight_date_time" class="form-control" id="flight_date_time" value="{{isset($edit) ? $passenger->flight_date_time:''}}">
                </div>
                <div class="mb-3">
                    <label for="flight_number" class="form-label">Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" id="flight_number" value="{{isset($edit) ? $passenger->flight_number:''}}">
                </div>
                <div class="mb-3">
                    <label for="flight_airline" class="form-label">Flight Airline</label>
                    <input type="text" name="flight_airline" class="form-control" id="flight_airline" value="{{isset($edit) ? $passenger->flight_airline:''}}">
                </div>
                <div class="mb-3">
                    <label for="flight_arriving_from" class="form-label">Flight Arriving From</label>
                    <input type="text" name="flight_arriving_from" class="form-control" id="flight_arriving_from" value="{{isset($edit) ? $passenger->flight_arriving_from:''}}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($edit) ? "Update Passenger":"Add Passenger" }}</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
