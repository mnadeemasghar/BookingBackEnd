@extends('welcome')
@section('content')
    <div class="col-12">
        <div class="rounded h-100 p-4">
            <h6 class="mb-4">Booking Data</h6>
            @if (isset($for_partner) && $for_partner)
                <a href="{{route('addBooking')}}" class="btn btn-primary">Create Booking</a>
            @endif
            <input id="searchPt" class="mt-3 form-control" placeholder="search...">
            <div class="row">
                <p>Transferz bookings...</p>
                @isset($transferz_bookings)
                    @foreach ($transferz_bookings as $transferz_booking)
                        <div class="card col-sm-1 col-md-6 col-lg-3 m-2">
                            <div class="card-body">
                                <i class="fa fa-key"></i> {{$transferz_booking['booking_id']}}
                                <br><i class="fa fa-map-marker"></i> {{$transferz_booking['destination']}}
                                <br><i class="fa fa-arrow-right"></i> {{$transferz_booking['location']}}
                                <br><i class="fa fa-clock"></i> {{date('d/m/Y H:m', strtotime($transferz_booking['pick_date_time']))}}
                                <br><i class="fa fa-car"></i> {{$transferz_booking['vehicle_type']}}
                                <br><i class="fa fa-th"></i> {{$transferz_booking['extras']}}
                                <br><i class="fa fa-users"></i> {{$transferz_booking['passenger_nos']}}
                            </div>
                        </div>
                    @endforeach
                @else
                <span>No Transferz booking</span>
                @endisset
            </div>

            <div class="row">
                <p>{{ env('APP_NAME') }} bookings...</p>
                @foreach ($bookings as $booking)
                    <div class="card col-sm-1 col-md-6 col-lg-3 m-2">
                        <div class="card-body">
                            <i class="fa fa-key"></i> {{$booking->booking_id}}
                            <br><i class="fa fa-map-marker"></i> {{$booking->destination}}
                            <br><i class="fa fa-arrow-right"></i> {{$booking->location}}
                            <br><i class="fa fa-clock"></i> {{date('d/m/Y H:m', strtotime($booking->pick_date_time))}}
                            <br><i class="fa fa-car"></i> {{$booking->vehicle_type}}
                            <br><i class="fa fa-th"></i> {{$booking->extras}}
                            <br><i class="fa fa-user"></i> {{$booking->driver_id}} - {{$booking->driver[0]->name ?? ""}}
                            <br><i class="fa fa-users"></i> {{$booking->passenger_nos}}

                            @if ($role == 'Admin' || $role == 'Partner')
                            <br><i class="fa fa-dollar-sign"></i>  {{ $booking->currency ?? "" }} {{ $booking->price ?? ""}}
                            @if (isset($booking->reason))
                            <br><i class="fa fa-pen"></i> {{$booking->reason ?? ""}}
                            @endif

                            @endif
                            <br><i class="fa fa-tasks"></i> {{$booking->status}}<br>

                            @if ($role == "Partner" || $role == "Admin")
                            <a href="{{route('viewLogs',['booking_id' => $booking->id])}}">
                                <i class="fa fa-user"></i>
                                Logs
                            </a><br>
                            <a href="{{route('passengers',['booking_id' => $booking->id])}}">
                                <i class="fa fa-user"></i>
                                Passengers
                            </a><br>
                            @elseif ($role == "Driver")
                            <a class="dropdown-item" href="{{route('viewPassengers',['booking_id' => $booking->id])}}">
                                <i class="fa fa-user"></i>
                                Passengers
                            </a>
                            @endif

                            @if ($role == "Admin")

                                @if ($booking->status == "pending")
                                <a  class="btn bg-gradient-success" href="{{route('acceptBooking',['id' => $booking->id])}}">
                                    Accept
                                    <i class="fa fa-check"></i>
                                </a>
                                <a class="btn bg-gradient-danger " href="{{route('rejectBooking',['id' => $booking->id])}}">
                                    Deny
                                    <i class="fa fa-times"></i>
                                </a>
                                @elseif ($booking->status == "accepted")
                                    <a class="" href="{{route('assignDriver',['booking_id' => $booking->id])}}">
                                        <i class="fa fa-plus"></i>
                                        Assign
                                    </a>

                            @endif

                            <div class="mt-5 dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($role == "Partner")
                                        <a class="dropdown-item" href="{{route('editBooking',['id' => $booking->id])}}">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item" href="{{route('deleteBooking',['id' => $booking->id])}}">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    @elseif ($role == "Admin")
                                        <a class="dropdown-item" href="{{route('editBooking',['id' => $booking->id])}}">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                        <a
                                            class="dropdown-item"
                                            href="{{route('deleteBooking',['id' => $booking->id])}}"
                                            onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};"
                                        >
                                                <i class="fa fa-trash"></i>
                                                Delete
                                        </a>
                                        @elseif ($booking->status == "assigned")
                                            <a class="dropdown-item" href="{{route('assignDriver',['booking_id' => $booking->id])}}">
                                                <i class="fa fa-plus"></i>
                                                Assign
                                            </a>
                                        @endif
                                    @elseif ($role == "Driver")
                                        @if ($booking->status == "assigned")
                                            <a class="dropdown-item" href="{{route('onTheWayBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                On the Way
                                            </a>
                                        @elseif ($booking->status == "ontheway")
                                            <a class="dropdown-item" href="{{route('arriveBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                Arrived
                                            </a>
                                        @elseif ($booking->status == "arrived")
                                            <a class="dropdown-item" class="text-success" href="{{route('onboardBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                Onboard
                                            </a>
                                            <a class="dropdown-item" class="text-danger" href="{{route('noshowBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                Customer not Shown
                                            </a>
                                        @elseif ($booking->status == "onboard")
                                            <a class="dropdown-item" href="{{route('completeBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                Complete
                                            </a>
                                            <a class="dropdown-item" href="{{route('addStopBooking',['id' => $booking->id])}}">
                                                <i class="fa fa-book"></i>
                                                Stops
                                            </a>
                                        @endif
                                    @endif
                                </div>
                              </div>
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
