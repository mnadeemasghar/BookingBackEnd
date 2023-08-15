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
            <h6 class="mb-4">Add Stops</h6>
            <form action="{{ route('addStopBookingPost',['id' => $id])}} " method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="stops" class="form-label">Add Stops</label>
                    <textarea name="stops" id="stops" class="form-control">{{ $booking->stops ?? "" }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->
    @endsection
