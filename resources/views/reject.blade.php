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
            <h6 class="mb-4">Reason for Rejection</h6>
            <form action="{{ route('rejectBookingPost',['id' => $id])}} " method="POST">
                @csrf
                <div class="mb-3">
                    <label for="reason" class="form-label">Rejection Reason</label>
                    <select name="reason" class="form-control" id="reason">
                        <option value="Price Mismatched">Price Mismatched</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
