@extends('welcome')
@section('content')
    <div class="rounded h-100 p-4">
        @if(session()->has('msg'))
            <div class="alert alert-info">
                {{ session()->get('msg') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <h6 class="mb-4">Reason for Rejection</h6>
        <form action="{{ route('rejectBookingPostTransferz',['id' => $id])}} " method="POST">
            @csrf
            <div class="mb-3">
                <label for="reason" class="form-label">Rejection Reason</label>
                <select name="reason" class="form-control" id="reason">
                    <option value="FARE_TOO_LOW">FARE_TOO_LOW</option>
                    <option value="NO_VEHICLE_AVAILABILITY">NO_VEHICLE_AVAILABILITY</option>
                    <option value="NO_DRIVER_AVAILABILITY">NO_DRIVER_AVAILABILITY</option>
                    <option value="ADDONS_NOT_AVAILABLE">ADDONS_NOT_AVAILABLE</option>
                    <option value="INCORRECT_JOURNEY_DETAILS">INCORRECT_JOURNEY_DETAILS</option>
                    <option value="HOLIDAY">HOLIDAY</option>
                    <option value="STRIKE">STRIKE</option>
                    <option value="DISTANCE_TOO_SHORT_OR_LONG">DISTANCE_TOO_SHORT_OR_LONG</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
