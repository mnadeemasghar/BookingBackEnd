@extends('welcome')
@section('content')
<div class="col-12">
    <div class="rounded h-100 p-4">
        <h6 class="mb-4">Logs Data for Booking ID: {{ $booking_id }}</h6>
        <div class="table-responsive">
            <table class="table  table-hover">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                        <th scope="col">User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking_timestamps as $booking_timestamp)
                        <tr>
                            <td>{{$booking_timestamp->status}}</td>
                            <td>{{$booking_timestamp->created_at}}</td>
                            <td>{{$booking_timestamp->user != Null ?? $booking_timestamp->user->id}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

