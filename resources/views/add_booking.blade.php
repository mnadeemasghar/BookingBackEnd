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
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 3%" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <a href="{{ isset($booking_id) ? route('passengers',['booking_id' => $booking_id]) : ''}}" class="btn btn-warning">
                            <i class="fa fa-user"></i>
                            Passengers
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="6">
                        <a href="{{ isset($booking_id) ? route('bookingDetail',['booking_id'=> $booking_id]) : '' }}" class="btn btn-warning">
                            <i class="fa fa-flag"></i>
                            Finalize
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step End -->
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
                            <label for="destination" class="form-label">Drop Off</label>
                            <input type="text" name="destination" class="form-control" value="{{ isset($edit) ? $booking->destination:'' }}" placeholder="City Center, train station. Etc. hotel or property" id="destination">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Pick Up</label>
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
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" value="{{ isset($edit) ? $booking->price:'' }}" class="form-control" id="price">
                        </div>
                        <div class="mb-3">
                            <label for="extras" class="form-label">Extras</label>
                            <div class="form-check">
                                <input class="form-check-input" name="extras['wheelchair']" type="checkbox" id="wheelchair">
                                <label class="form-check-label" for="wheelchair">
                                    wheelchair
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="extras['babyseat']" type="checkbox" id="babyseat">
                                <label class="form-check-label" for="babyseat">
                                    babyseat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="extras['childseat']" type="checkbox" id="childseat">
                                <label class="form-check-label" for="childseat">
                                    childseat
                                </label>
                            </div>
                            {{-- <input type="text" name="extras" class="form-control" value="{{ isset($edit) ? $booking->extras:'' }}" placeholder="Wheelchair, Baby seat, child seat with additional cost" id="extras"> --}}
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
