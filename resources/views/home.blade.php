@extends('welcome')
@section('content')

    <!-- Content Start -->
    <div class="content">
        @include('navbar')


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
