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


        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <h1>{{ $role }} - Dashboard</h1>
            <div class="row g-4">
                @foreach ($data['cards'] as $card)
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            {!! $card['card_icon'] !!}
                            <div class="ms-3">
                                <p class="mb-2">{{ $card['card_title'] }}</p>
                                <h6 class="mb-0">{{ $card['card_value'] }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Sale & Revenue End -->



@endsection
