@extends('backend.global.master')

@section('title', 'Admin DashBoard')
@section('heading', 'DashBoard')


@section('backend_custom_style')
@endsection


@section('backend_content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-default">
                <div class="card-header d-flex justify-content-between">
                    <h5>Manpower Qty</h5>
                    <a class="btn btn-primary btn-sm btn-pill" href="{{ route('manpowerIndex') }}">Go to Manpower
                        Management</a>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-around">
                        <div class="text-center p-3">
                            <h4>Snacks - Morning </h4>
                            <p>{{ $snacksMorning_array['shifts'] ?? 'No shifts data available' }}</p>
                            <span class="h3 text-primary">{{ $snacksMorning_array['count'] ?? '0' }} People</span>
                        </div>

                        <div class="text-center p-3">
                            <h4>Snacks - Afternoon</h4>
                            <p>{{ $snacksAfternoon_array['shifts'] ?? 'No shifts data available' }}</p>
                            <span class="h3 text-warning">{{ $snacksAfternoon_array['count'] ?? '0' }} People</span>
                        </div>

                        <div class="text-center p-3">
                            <h4>Lunch</h4>
                            <p>{{ $lunch_array['shifts'] ?? 'No shifts data available' }}</p>
                            <span class="h3 text-success">{{ $lunch_array['count'] ?? '0' }} People</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card card-default">
                <div class="card-header d-flex justify-content-between">
                    <h2>Snacks Items Qty</h2>
                    <a class="btn btn-primary btn-sm btn-pill" href="{{ route('menuItemIndex') }}">Go to Menu Management</a>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="text-center">
                            <h4>Morning - Snacks - Items</h4>
                            @forelse ($snackItemsMorning as $itemName => $quantity)
                                <div class="mb-1">
                                    <strong>{{ $itemName }}:</strong> {{ $quantity }}
                                </div>
                            @empty
                                <p>No data found</p>
                            @endforelse
                        </div>

                        <div class="text-center">
                            <h4>Afternoon - Snacks - Items</h4>
                            @forelse ($snackItemsAfternoon as $itemName => $quantity)
                                <div class="mb-1">
                                    <strong>{{ $itemName }}:</strong> {{ $quantity }}
                                </div>
                            @empty
                                <p>No data found</p>
                            @endforelse
                        </div>

                        <div class="text-center">
                            <h4>Lunch  Items</h4>
                            @forelse ($lunchItems as $itemName => $quantity)
                                <div class="mb-1">
                                    <strong>{{ $itemName }}:</strong> {{ number_format($quantity / 1000, 2) }} kg
                                </div>
                            @empty
                                <p>No data found</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
