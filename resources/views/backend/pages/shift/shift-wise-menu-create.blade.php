@extends('backend.global.master')

@section('title', 'Shift Wise Menu Create')
@section('heading', 'Shift Wise Menu Create')


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
                    <h2>Shift Wise Menu Create </h2>
                    <a href="{{ route('shiftWiseMenuIndex') }}" class="btn btn-primary">
                        Back To Index
                    </a>
                </div>
                <div class="card-body">
                    <!-- Store Form -->
                    <form id="shiftWiseMenuForm" action="{{ route('shiftWiseMenuStore') }}" method="POST">
                        @csrf
                        <!-- Menu Type Selection -->
                        <x-select class="form-control" label="Select Menu Type:" name="menu_id" id="menu_id">
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->type }}</option>
                            @endforeach
                        </x-select>

                        <div class="form-group" id="time_of_day_wrapper" style="display: none;">
                            <x-select class="form-control" label="Select Time of Day:" name="time_of_day" id="time_of_day">
                                <option selected disabled>Select Time of Day</option>
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                            </x-select>
                        </div>


                        <div class="form-group col-md-12 mb-4">
                            <label class="text-dark font-weight-medium">Select Shift</label>
                            <select class="js-example-basic-multiple form-control" name="shift_id[]" multiple="multiple">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-button id="submit" type="submit" class="btn btn-primary">
                            <span>Save</span>
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
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#shiftWiseMenuForm').on('submit', function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();

                // AJAX request
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
                                toastr.error('An error occurred while processing your request.',
                                    'Error');
                            }
                    }
                });
            });
        });
    </script>
@endsection
