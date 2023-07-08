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
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
