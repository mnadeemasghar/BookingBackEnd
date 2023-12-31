@extends('welcome')
@section('content')

    <!-- Content Start -->
    <div class="content">
        @include('navbar')


        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Log Data for: {{ $logged_user->id . " " . $logged_user->name }}</h6>
                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Activity</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userlogs as $passenger)
                                        <tr>
                                            <td>{{$passenger->id}}</td>
                                            <td>{{$passenger->activity}}</td>
                                            <td>{{$passenger->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table End -->



@endsection

