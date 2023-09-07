@extends('welcome')
@section('content')
<div class="row g-4 ">
    <div class="col-sm-12 col-xl-6">
        <div class="rounded h-100 p-4">
            @if(session()->has('msg'))
                <div class="alert alert-info">
                    {{ session()->get('msg') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <h6 class="mb-4">{{ "Update Transferz User" }}</h6>
            <form action="{{ route('updateTransferzUser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="TRANSFERZ_EMAIL" class="form-label">TRANSFERZ_EMAIL</label>
                    <input type="text" name="TRANSFERZ_EMAIL" class="form-control" id="TRANSFERZ_EMAIL" value="{{ $email ?? "" }}">
                </div>
                <div class="mb-3">
                    <label for="TRANSFERZ_PASSWORD" class="form-label">TRANSFERZ_PASSWORD</label>
                    <input type="text" name="TRANSFERZ_PASSWORD" class="form-control" id="TRANSFERZ_PASSWORD" value="{{ $password ?? "" }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ "Update User" }}</button>
            </form>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6">
        <div class="rounded h-100 p-4 d-flex h-100 align-items-center">
            <img class="img-fluid" src="{{ isset($edit) ? asset('license_imgs/'.$driver->license_img): asset('partner.png') }}" alt="">
        </div>
    </div>
</div>
    @endsection
