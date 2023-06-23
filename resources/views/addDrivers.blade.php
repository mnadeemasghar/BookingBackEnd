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
        <div class="row g-4 ">
            <div class="col-sm-12 col-xl-6">
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
                    <h6 class="mb-4">{{ isset($edit) ? "Update Driver":"Add Driver"}}</h6>
                    <form action="{{ isset($edit) ? route('updateDrivers',['id'=>$driver->id]) : route('storeDrivers')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{isset($edit) ? $driver->name:''}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{isset($edit) ? $driver->email:''}}">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" value="{{isset($edit) ? $driver->password:''}}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($edit) ? "Update Driver":"Add Driver" }}</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4 d-flex h-100 align-items-center">
                    <img class="img-fluid" src="{{asset('partner.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->

    <!-- Content End -->


    @endsection
