@extends('welcome')
@section('content')
    <div class="col-12">
        <div class="rounded h-100 p-4">
            <h6 class="mb-4">Booking Data</h6>
            @if (isset($for_partner) && $for_partner)
                <a href="{{route('addBooking')}}" class="btn btn-primary">Create Booking</a>
            @endif
            <input id="searchPt" class="form-control" placeholder="search...">
            <div class="row">
                @foreach ($bookings as $booking)
                    <div class="card col-sm-1 col-md-6 col-lg-3 m-2">
                        <div class="card-body">
                            <i class="fa fa-key"></i> {{$booking->booking_id}}
                            <br><i class="fa fa-map-marker"></i> {{$booking->destination}}
                            <br><i class="fa fa-arrow-right"></i> {{$booking->location}}
                            <br><i class="fa fa-clock"></i> {{$booking->pick_date_time}}
                            <br><i class="fa fa-car"></i> {{$booking->vehicle_type}}
                            <br><i class="fa fa-th"></i> {{$booking->extras}}
                            <br><i class="fa fa-user"></i> {{$booking->driver_id}} - {{$booking->driver[0]->name ?? ""}}
                            <br><i class="fa fa-users"></i> {{$booking->passenger_nos}}

                            @if ($role == 'Admin' || $role == 'Partner')
                            <br><i class="fa fa-dollar-sign"></i>  {{ $booking->currency ?? "" }} {{ $booking->price ?? ""}}
                            <br><i class="fa fa-pen"></i> {{$booking->reason ?? ""}}
                            @endif
                            <br><i class="fa fa-tasks"></i> {{$booking->status}}<br>

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

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Wait for the document to be fully loaded
        document.addEventListener("DOMContentLoaded", function() {
        // Find the input element with the ID 'searchPt'
        const searchPtInput = document.getElementById("searchPt");

        // Listen for the 'keyup' event on the input element
        searchPtInput.addEventListener("keyup", function() {
            const searchText = searchPtInput.value.trim(); // Get the trimmed value of the input

            // Find elements with the class 'row'
            const rowElements = document.querySelectorAll(".card");

            // Loop through each 'row' element
            rowElements.forEach(rowElement => {
                const childElements = rowElement.querySelectorAll("*");
                let hasMatch = false;

                childElements.forEach(childElement => {
                    // Check if the text content of the element matches the search text
                    if (childElement.textContent.includes(searchText)) {
                    hasMatch = true;
                    // childElement.classList.add("bg-danger");
                    } else {
                    // childElement.classList.remove("bg-danger");
                    }

                });
                // Add or remove 'd-none' class based on search match
                if (hasMatch) {
                    rowElement.classList.remove("d-none");
                } else {
                    rowElement.classList.add("d-none");
                }
            });
        });
        });

    </script>
@endsection
