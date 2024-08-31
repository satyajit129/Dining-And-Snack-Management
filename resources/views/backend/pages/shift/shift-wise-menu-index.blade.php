@extends('backend.global.master')

@section('title', 'Shift Wise Menu Index')
@section('heading', 'Shift Wise Menu Index')


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
                    <h2>Shift Wise Menu Index </h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                        Add Shift Wise Menu
                    </button>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection



@section('backend_custom_js')

@endsection
