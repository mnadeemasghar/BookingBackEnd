@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    @include('navbar')


    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
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
            <h6 class="mb-4">Customer not Shown</h6>
            <form action="{{ route('noshowBookingPost',['id' => $id])}} " method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="not_shown_img" class="form-label">Select Image</label>
                    <input type="file" name="not_shown_img" class="form-control" id="not_shown_img">
                    <input type="text" name="lat" id="lat" class="d-none">
                    <input type="text" name="lon" id="lon" class="d-none">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p>Your current location is:</p>
            <p id="location"></p>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    <script>
        document.addEventListener("DOMContentLoaded", function () {
        getLocation();
        });
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        document.getElementById("location").innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;
        document.getElementById("lat").value = latitude;
        document.getElementById("lon").value = longitude;
      }

      function showError(error) {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
          case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
          case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
          case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
        }
      }
    </script>
    @endsection
