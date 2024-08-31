@extends('backend.global.master')

@section('title', 'Prediction Report Index')
@section('heading', 'Prediction Report Index')


@section('backend_custom_style')
@endsection


@section('backend_content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-default">
                @if (session('success'))
                    <div class="alert alert-success alert-icon" role="alert">
                        <i class="mdi mdi-checkbox-marked-outline"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-icon" role="alert">
                        <i class="mdi mdi-alert-outline"></i> {{ session('error') }}
                    </div>
                @endif
                <div class="card-header align-items-center px-3 px-md-5">
                    <h2>Prediction Report Index <span class="text-danger">(Based On Previous Data) To view the actual data for today <a href="{{ route('adminDashboard') }}">please click here</a></span></h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Morning Snacks - Today's Prediction -->
                        @if(isset($averageMorningSnacksToday) && isset($predictedMorningSnacksToday) && isset($predictedSnackItemsMorningToday))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Morning Snacks - Today </h2>
                                        <span class="badge badge-sm bg-info text-white">Data for the present day is not included in the Today Prediction.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Snacks - Morning (Today):</strong> {{ number_format($averageMorningSnacksToday , 2) }}</p>
                                        <p><strong>Predicted Snacks - Morning (Today):</strong> {{ number_format($predictedMorningSnacksToday , 2) }}</p>
                                        @if(isset($predictedSnackItemsMorningToday) && count($predictedSnackItemsMorningToday) > 0)
                                            @foreach ($predictedSnackItemsMorningToday as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity , 2) }} Pics</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted items for Morning Snacks (Today) available.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Morning Snacks - Next Day Prediction -->
                        @if(isset($averageMorningSnacksNextDay) && isset($predictedMorningSnacksNextDay) && isset($predictedSnackItemsMorningNextDay))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Morning Snacks - Next Day</h2>
                                        <span class="badge badge-sm bg-info text-white">Includes today's data, if available.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Snacks - Morning (Next Day):</strong> {{ number_format($averageMorningSnacksNextDay , 2) }}</p>
                                        <p><strong>Predicted Snacks - Morning (Next Day):</strong> {{ number_format($predictedMorningSnacksNextDay , 2) }}</p>
                                        @if(isset($predictedSnackItemsMorningNextDay) && count($predictedSnackItemsMorningNextDay) > 0)
                                            @foreach ($predictedSnackItemsMorningNextDay as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity, 2) }} Pics</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted items for Morning Snacks (Next Day) available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Afternoon Snacks - Today's Prediction -->
                        @if(isset($averageAfternoonSnacksToday) && isset($predictedAfternoonSnacksToday) && isset($predictedSnackItemsAfternoonToday))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Afternoon Snacks - Today</h2>
                                        <span class="badge badge-sm bg-info text-white">Data for the present day is not included in the Today Prediction.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Snacks - Afternoon (Today):</strong> {{ number_format($averageAfternoonSnacksToday , 2) }}</p>
                                        <p><strong>Predicted Snacks - Afternoon (Today):</strong> {{ number_format($predictedAfternoonSnacksToday , 2) }}</p>
                                        @if(isset($predictedSnackItemsAfternoonToday) && count($predictedSnackItemsAfternoonToday) > 0)
                                            @foreach ($predictedSnackItemsAfternoonToday as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity , 2) }} Pics</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted items for Afternoon Snacks (Today) available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Afternoon Snacks - Next Day Prediction -->
                        @if(isset($averageAfternoonSnacksNextDay) && isset($predictedAfternoonSnacksNextDay) && isset($predictedSnackItemsAfternoonNextDay))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Afternoon Snacks - Next Day</h2>
                                        <span class="badge badge-sm bg-info text-white">Includes today's data, if available.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Snacks - Afternoon (Next Day):</strong> {{ number_format($averageAfternoonSnacksNextDay , 2) }}</p>
                                        <p><strong>Predicted Snacks - Afternoon (Next Day):</strong> {{ number_format($predictedAfternoonSnacksNextDay , 2) }}</p>
                                        @if(isset($predictedSnackItemsAfternoonNextDay) && count($predictedSnackItemsAfternoonNextDay) > 0)
                                            @foreach ($predictedSnackItemsAfternoonNextDay as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity , 2) }} Pics</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted items for Afternoon Snacks (Next Day) available.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Lunch - Today's Prediction -->
                        @if(isset($averageLunchToday) && isset($predictedLunchToday) && isset($predictedLunchItemsToday))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Lunch - Today</h2>
                                        <span class="badge badge-sm bg-info text-white">Data for the present day is not included in the Today Prediction.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Lunch (Today):</strong> {{ number_format($averageLunchToday , 2) }}</p>
                                        <p><strong>Predicted Lunch (Today):</strong> {{ number_format($predictedLunchToday , 2) }}</p>
                                        @if(isset($predictedLunchItemsToday) && count($predictedLunchItemsToday) > 0)
                                            @foreach ($predictedLunchItemsToday as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity / 1000, 2) }} kg</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted lunch items for today available.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Lunch - Next Day Prediction -->
                        @if(isset($averageLunchNextDay) && isset($predictedLunchNextDay) && isset($predictedLunchItemsNextDay))
                            <div class="col-xl-6">
                                <div class="card card-default">
                                    <div class="card-header align-items-center px-3 px-md-5">
                                        <h2>Lunch - Next Day</h2>
                                        <span class="badge badge-sm bg-info text-white">Includes today's data, if available.</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Average Lunch (Next Day):</strong> {{ number_format($averageLunchNextDay , 2) }}</p>
                                        <p><strong>Predicted Lunch (Next Day):</strong> {{ number_format($predictedLunchNextDay , 2) }}</p>
                                        @if(isset($predictedLunchItemsNextDay) && count($predictedLunchItemsNextDay) > 0)
                                            @foreach ($predictedLunchItemsNextDay as $item => $quantity)
                                                @if(isset($item) && isset($quantity))
                                                    <p>{{ $item }}: {{ number_format($quantity / 1000, 2) }} kg</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No predicted lunch items for the next day available.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('backend_custom_js')

@endsection
