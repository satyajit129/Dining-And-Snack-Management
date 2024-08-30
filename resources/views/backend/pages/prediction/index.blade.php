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
                    <h2>Prediction Report Index</h2>
                </div>
                <div class="card-body">
                    <h1>Prediction Report</h1>

        <h2>Today's Predictions</h2>
        <p><strong>Snacks (Morning):</strong> {{ $snacksMorning }} people</p>
        <p><strong>Snacks (Afternoon):</strong> {{ $snacksAfternoon }} people</p>
        <p><strong>Lunch:</strong> {{ $lunch }} people</p>

        <h2>Tomorrow's Predictions</h2>
        <p><strong>Snacks (Morning):</strong> {{ $snacksMorningTomorrow }} people</p>
        <p><strong>Snacks (Afternoon):</strong> {{ $snacksAfternoonTomorrow }} people</p>
        <p><strong>Lunch:</strong> {{ $lunchTomorrow }} people</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')

@endsection
