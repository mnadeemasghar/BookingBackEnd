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
                        <h6 class="mb-4">Logs Data for Booking ID: {{ $booking_id }}</h6>
                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking_timestamps as $booking_timestamp)
                                        <tr>
                                            <td>{{$booking_timestamp->status}}</td>
                                            <td>{{$booking_timestamp->created_at}}</td>
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

