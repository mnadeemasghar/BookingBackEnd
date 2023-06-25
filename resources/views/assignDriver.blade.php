@extends('welcome')
@section('content')


<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="{{route('home')}}" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
            <input class="form-control bg-dark border-0" type="search" placeholder="Search">
        </form>
        <div class="navbar-nav align-items-center ms-auto">
        </div>
    </nav>
    <!-- Navbar End -->


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
            <h6 class="mb-4">Assign Driver</h6>
            <form action="{{ route('assignDriverStore',['booking_id' => $booking->id])}} " method="POST">
                @csrf
                <div class="mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select name="driver_id" class="form-control" id="driver_id">
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->id }} - {{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Assign Driver</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
