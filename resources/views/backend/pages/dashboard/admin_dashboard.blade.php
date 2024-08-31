@extends('backend.global.master')

@section('title', 'Admin DashBoard')
@section('heading', 'DashBoard')


@section('backend_custom_style')
@endsection


@section('backend_content')
    <div class="row">


        <!-- Single Card for Manpower Quantity -->
        @if (isset($snacksMorning_array) || isset($snacksAfternoon_array) || isset($lunch_array))
        <div class="col-xl-12">
            <div class="card card-default">
                <div class="card-header d-flex justify-content-between">
                    <h2>Manpower Qty ({{ $weekday_name }})</h2>
                    <a class="btn btn-primary btn-sm btn-pill" href="{{ route('manpowerIndex') }}">Go to Manpower Management</a>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-around">
                        <!-- Snacks Morning -->
                        @if (isset($snacksMorning_array))
                            <div class="text-center p-3">

                                <h4>Snacks - Morning <br>({{ $snacksMorning_array['shiftA'] }} & {{ $snacksMorning_array['generalShift'] }})</h4>
                                <span class="h3 text-primary">{{ $snacksMorning_array['count'] }} People</span>
                            </div>
                        @endif

                        <!-- Snacks Afternoon -->
                        @if (isset($snacksAfternoon_array))
                            <div class="text-center p-3">
                                <h4>Snacks - Afternoon <br>({{ $snacksAfternoon_array['shiftB'] }} & {{ $snacksAfternoon_array['shiftC'] }})</h4>

                                <span class="h3 text-warning">{{ $snacksAfternoon_array['count'] }} People</span>
                            </div>
                        @endif
                        <!-- Lunch -->
                        @if (isset($lunch_array))
                            <div class="text-center p-3">
                                <h4>Lunch <br>({{ $lunch_array['shiftA'] }} , {{ $lunch_array['generalShift'] }} & {{ $lunch_array['shiftB'] }})</h4>
                                <span class="h3 text-success">{{ $lunch_array['count'] }} People</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif


        <!-- Single Card for Snacks Items Quantity -->
        @if ($snackItemsMorning >= 0 || $snackItemsAfternoon >= 0)
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h2>Snacks Items Qty ({{ $weekday_name }})</h2>
                        <a class="btn btn-primary btn-sm btn-pill" href="{{ route('menuItemIndex') }}">Go to Menu Management</a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-around">
                            @if ($snackItemsMorning >= 0)
                                <div class="text-center">
                                    <h4>Snacks - Morning</h4>
                                    @foreach ($snackItemsMorning as $item => $quantity)
                                        <p>{{ $item }}: {{ $quantity }} Pics</p>
                                    @endforeach
                                </div>
                            @endif
                            @if ($snackItemsAfternoon >= 0)
                                <div class="text-center">
                                    <h4>Snacks - Afternoon</h4>
                                    @foreach ($snackItemsAfternoon as $item => $quantity)
                                        <p>{{ $item }}: {{ $quantity }} Pics</p>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Single Card for Lunch Items Quantity -->
        @if ($lunchItems >= 0)
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h2>Lunch Items Qty ({{ $weekday_name }})</h2>
                        <a class="btn btn-primary btn-sm btn-pill" href="{{ route('menuItemIndex') }}">Go to Menu Management</a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-around">
                            <div class="text-center">
                                <h4>Lunch</h4>
                                @foreach ($lunchItems as $item => $quantity)
                                    <p>{{ $item }}: {{ number_format($quantity / 1000, 2) }} kg</p>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif



    </div>
@endsection

@section('backend_custom_js')
@endsection
