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
            <h6 class="mb-4">{{ isset($edit) ? "Update Partner":"Add Partner"}}</h6>
            <form action="{{ isset($edit) ? route('updatePartners',['id'=>$partner->id]) : route('storePartners')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{isset($edit) ? $partner->name:''}}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" value="{{isset($edit) ? $partner->email:''}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" value="{{isset($edit) ? $partner->password:''}}" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($edit) ? "Update Partner":"Add Partner" }}</button>
            </form>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6">
        <div class="rounded h-100 p-4 d-flex h-100 align-items-center">
            <img class="img-fluid" src="{{asset('partner.png')}}" alt="">
        </div>
    </div>
</div>
    @endsection
