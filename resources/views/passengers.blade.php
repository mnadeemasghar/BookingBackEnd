@extends('welcome')
@section('content')
    <div class="col-12">
        <!-- Step Start -->

        <div class="row mb-5">
            <div class="progress bg-transparent mb-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 33%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="6">
                        <a href="{{ $role == 'Admin' || $role == 'Partner' ? route('bookings') : '' }}" class="btn btn-warning">
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
        <div class="rounded h-100 p-4">
            <h6 class="mb-4">Passengers Data</h6>
            @if ($passengers->count() > 0)

            @else
                @if ($role == 'Admin' || $role == 'Partner')
                    <a href="{{route('addPassenger',['booking_id' => $booking_id])}}" class="btn btn-primary">Add Passenger</a>
                @endif
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
                                    @if ($role == 'Admin' || $role == 'Partner')
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('editPassenger',['id'=>$passenger->id])}}"> <i class="fa fa-edit"></i>Edit</a>
                                            <a class="dropdown-item" href="{{route('deletePassenger',['id'=>$passenger->id])}}" onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};" > <i class="fa fa-trash mr-2"></i>Delete</a>
                                        </div>
                                      </div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

