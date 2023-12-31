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
            <h6 class="mb-4">Assign Driver</h6>
            <form action="{{ route('assignDriverStore',['booking_id' => $booking->id])}} " method="POST">
                @csrf
                <div class="mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select name="driver_id" class="form-control" id="driver_id">
                        @foreach ($drivers as $driver)
                            @if ($driver->available)
                                <option value="{{ $driver->id }}">{{ $driver->id }} - {{ $driver->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price_driver" class="form-label">Driver Price</label>
                    <input type="text" name="price_driver" class="form-control" id="price_driver">
                </div>
                <button type="submit" class="btn btn-primary">Assign Driver</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
