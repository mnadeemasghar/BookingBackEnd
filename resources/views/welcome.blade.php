<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env("APP_NAME", "App Name")}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href={{asset("plugins/fontawesome-free/css/all.min.css")}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{asset("dist/css/adminlte.min.css")}}>

  <style>
    .notification .badge {
        /* position: absolute;
        top: -10px;
        right: -10px; */
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
        }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href={{route("home")}} class="brand-link">
      <img src={{asset("dist/img/AdminLTELogo.png")}} alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ env("APP_NAME", "App Name") }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src={{asset("dist/img/user2-160x160.jpg")}} class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block">{{ $name }}</a>
        </div>
      </div>


      {{-- side navbar start --}}
      <div class="sidebar">
            {{-- <nav class="navbar"> --}}
                <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa fa-tachometer-alt mr-5"></i>Dashboard</a>
                @if ($role == 'Admin')
                    <a href="{{route('drivers')}}" class="nav-item nav-link {{ request()->routeIs('drivers') ? 'active' : '' }}"><i class="fa fa-car mr-5"></i>Drivers</a>
                    <a href="{{route('partners')}}" class="nav-item nav-link {{ request()->routeIs('partners') ? 'active' : '' }}"><i class="fa fa-handshake mr-5"></i></i>Partners</a>
                    <a href="{{route('vehicleTypes')}}" class="nav-item nav-link {{ request()->routeIs('vehicleTypes') ? 'active' : '' }}"><i class="fa fa-car mr-5"></i></i>Vehicle Types</a>
                    <a href="{{route('pendingBookings')}}" class="nav-item nav-link {{ request()->routeIs('pendingBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Bookings</a>
                    <a href="{{route('unattendedBookings')}}" class="nav-item nav-link notification {{ request()->routeIs('unattendedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Unattended<span class="badge">{{Helper::unattended_rides()->count()}}</span></a>
                    <a href="{{route('transferzUser')}}" class="nav-item nav-link {{ request()->routeIs('transferzUser') ? 'active' : '' }}"><i class="fa fa-user mr-5"></i></i>Transferz User</a>
                    {{-- <a href="{{route('acceptedBookings')}}" class="nav-item nav-link {{ request()->routeIs('acceptedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Accepted</a>
                    <a href="{{route('assignedBookings')}}" class="nav-item nav-link {{ request()->routeIs('assignedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Assigned</a>
                    <a href="{{route('rejectedBookings')}}" class="nav-item nav-link {{ request()->routeIs('rejectedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Rejected</a> --}}
                @elseif ($role == 'Partner')
                    <a href="{{route('bookings')}}" class="nav-item nav-link {{ request()->routeIs('bookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Bookings</a>
                @elseif ($role == 'Driver')
                    <a href="{{route('assignedDriverBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('assignedDriverBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Bookings</a>
                    {{-- <a href="{{route('arrivedBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('arrivedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Arrived</a>
                    <a href="{{route('onboardBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('onboardBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Onboard</a>
                    <a href="{{route('completedBookings',['driver_id'=>$id])}}" class="nav-item nav-link {{ request()->routeIs('completedBookings') ? 'active' : '' }}"><i class="fa fa-book mr-5"></i></i>Completed</a> --}}
                @endif
                <a href="{{route('logout')}}" class="nav-item nav-link"><i class="fa fa-chart-bar mr-5"></i>Logout</a>
            {{-- </nav> --}}
        </div>
      {{-- side navbar end --}}

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 {{env("APP_NAME","App Name")}}.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src={{asset("plugins/jquery/jquery.min.js")}}></script>
<!-- Bootstrap 4 -->
<script src={{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("dist/js/adminlte.min.js")}}></script>
</body>
</html>
