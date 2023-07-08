<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NXL Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />

</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{route('home')}}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>NXL</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $name }}</h6>
                        <span>{{ $role }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    @if ($role == 'Admin')
                        <a href="{{route('drivers')}}" class="nav-item nav-link {{ request()->routeIs('drivers') ? 'active' : '' }}"><i class="fa fa-car me-2"></i>Drivers</a>
                        <a href="{{route('partners')}}" class="nav-item nav-link {{ request()->routeIs('partners') ? 'active' : '' }}"><i class="fa fa-handshake me-2"></i></i>Partners</a>
                        <a href="{{route('vehicleTypes')}}" class="nav-item nav-link {{ request()->routeIs('vehicleTypes') ? 'active' : '' }}"><i class="fa fa-car me-2"></i></i>Vehicle Types</a>
                        <a href="{{route('pendingBookings')}}" class="nav-item nav-link {{ request()->routeIs('pendingBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Bookings</a>
                        {{-- <a href="{{route('acceptedBookings')}}" class="nav-item nav-link {{ request()->routeIs('acceptedBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Accepted</a>
                        <a href="{{route('assignedBookings')}}" class="nav-item nav-link {{ request()->routeIs('assignedBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Assigned</a>
                        <a href="{{route('rejectedBookings')}}" class="nav-item nav-link {{ request()->routeIs('rejectedBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Rejected</a> --}}
                    @elseif ($role == 'Partner')
                        <a href="{{route('bookings')}}" class="nav-item nav-link {{ request()->routeIs('bookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Bookings</a>
                    @elseif ($role == 'Driver')
                        <a href="{{route('assignedDriverBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('assignedDriverBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Bookings</a>
                        {{-- <a href="{{route('arrivedBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('arrivedBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Arrived</a>
                        <a href="{{route('onboardBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('onboardBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Onboard</a>
                        <a href="{{route('completedBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('completedBookings') ? 'active' : '' }}"><i class="fa fa-book me-2"></i></i>Completed</a> --}}
                    @endif
                    <a href="{{route('logout')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
        @yield('content')
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        &copy; <a href="#">NXL</a>, All Right Reserved.
                    </div>
                    <div class="col-12 col-sm-6 text-center text-sm-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a href="#">Luxsit Technologies</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    </div>
    <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/chart/chart.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>


    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</body>

</html>
