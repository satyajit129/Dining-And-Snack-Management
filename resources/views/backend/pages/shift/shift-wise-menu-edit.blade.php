@extends('backend.global.master')

@section('title', 'Shift Wise Menu Edit')
@section('heading', 'Shift Wise Menu Edit')

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
                    <h2>Edit Shift Wise Menu</h2>
                    <a href="{{ route('shiftWiseMenuIndex') }}" class="btn btn-primary">
                        Back To Index
                    </a>
                </div>
                <div class="card-body">
                    <!-- Edit Form -->
                    <form id="shiftWiseMenuForm" action="{{ route('shiftWiseMenuUpdate', $shiftWiseMenu->id) }}" method="POST">
                        @csrf
                        <!-- Menu Type Selection -->
                        <x-select class="form-control" label="Select Menu Type:" name="menu_id" id="menu_id">
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" {{ $menu->id == $shiftWiseMenu->menu_id ? 'selected' : '' }}>
                                    {{ $menu->type }}
                                </option>
                            @endforeach
                        </x-select>

                        <!-- Time of Day Selection (only for Snacks) -->
                        <div class="form-group" id="time_of_day_wrapper" style="{{ $shiftWiseMenu->menu_id == 1 ? 'display: block;' : 'display: none;' }}">
                            <x-select class="form-control" label="Select Time of Day:" name="time_of_day" id="time_of_day">
                                <option selected disabled>Select Time of Day</option>
                                <option value="morning" {{ $shiftWiseMenu->time_of_day == 'morning' ? 'selected' : '' }}>Morning</option>
                                <option value="afternoon" {{ $shiftWiseMenu->time_of_day == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                            </x-select>
                        </div>

                        <div class="form-group col-md-12 mb-4">
                            <label class="text-dark font-weight-medium">Select Shift</label>
                            <select class=" form-control" name="shift_id" >
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ $shift->id == $shiftWiseMenu->shift_id ? 'selected' : '' }}>
                                        {{ $shift->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-button id="submit" type="submit" class="btn btn-primary">
                            <span>Update</span>
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')
    <script>
        $(document).ready(function() {
            $('#menu_id').on('change', function() {
                var menuType = $(this).val();
                var timeOfDayWrapper = $('#time_of_day_wrapper');

                if (menuType === '1') {
                    timeOfDayWrapper.show();
                } else {
                    timeOfDayWrapper.hide();
                }
            }).trigger('change'); // Trigger change to set initial state

            $('#shiftWiseMenuForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        toastr.success(response.success);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        } else {
                            toastr.error('An error occurred while processing your request.', 'Error');
                        }
                    }
                });
            });
        });
    </script>
@endsection