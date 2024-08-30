@extends('backend.global.master')

@section('title', 'ManPower Index')
@section('heading', 'ManPower Index')


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
                    <h2>ManPower Index</h2>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                        Add ManPower
                    </button>
                </div>
                <div class="card-body">

                    <table class="table" id="ManpowerFormtable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Shift Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Count</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manpowers as $manpower)
                            @php
                                $isToday = \Carbon\Carbon::parse($manpower->date)->isToday();
                            @endphp
                                <tr id="manpower-row-{{ $manpower->id }}" class="{{ $isToday ? 'bg-info text-white' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $manpower->shift->name }}</td>
                                    <td>{{ $manpower->date }}</td>
                                    <td>{{ $manpower->count }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $manpower->id }}"
                                            data-shift-id="{{ $manpower->shift_id }}" data-count="{{ $manpower->count }}"
                                            data-date="{{ $manpower->date }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $manpower->id }}"
                                            data-shift-id="{{ $manpower->shift_id }}" data-count="{{ $manpower->count }}"
                                            data-date="{{ $manpower->date }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $manpowers->links() }}
                </div>
            </div>
        </div>
        {{-- Add Modal --}}
        <x-modal id="modal_add" labelledby="addManpowerLabel" title="Add ManPower">
            <form id="manpowerForm" method="POST">
                @csrf
                <x-select name="shift_id" class="form-control" id="shift_id" label="Shift">
                    <option selected disabled>Select Shift</option>
                    @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                </x-select>
                <x-input type="number" id="count" name="count" value="{{ old('count') }}"
                    placeholder="Enter your count" label="Count" />
                
            </form>

            <x-slot name="footer">
                <button type="button" id="submitManpowerForm" class="btn btn-primary">Save changes</button>
            </x-slot>
        </x-modal>
        {{-- Add Modal --}}

        {{-- Edit Modal --}}
        <x-modal id="modal_edit" labelledby="editManpowerLabel" title="Edit ManPower">
            <div id="modal_edit_content">

            </div>
        </x-modal>
        {{-- Edit Modal --}}
    </div>
@endsection

@section('backend_custom_js')
    {{-- add man power --}}
    <script>
        $(document).ready(function() {
            $('#submitManpowerForm').on('click', function(e) {
                e.preventDefault();

                let formData = $('#manpowerForm').serialize();
                // console.log(formData);

                $.ajax({
                    url: "{{ route('manpowerStore') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('#modal_add').modal('hide');
                        let formatted_date = moment(response.manpower.date).format(
                            'YYYY-MM-DD');
                            let rowCount = $('#ManpowerFormtable tr').length;
                            let newIndex = rowCount;
                        let newRow = `
                        <tr>
                            <td>${rowCount}</td>
                            <td>${response.manpower.shift.name}</td>
                            <td>${formatted_date}</td>
                            <td>${response.manpower.count}</td>
                            <td><button class="btn btn-warning btn-sm edit-btn" data-id="${response.manpower.id}">Edit</button></td>
                            <td><button class="btn btn-danger btn-sm delete-btn" data-id="${response.manpower.id}">Delete</button></td>
                        </tr>
                    `;
                        $('#ManpowerFormtable').append(newRow);
                        if (response) {
                            toastr.success(response.success);
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#modal_add').modal('hide');
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        } else {
                            toastr.error('An error occurred while processing your request.',
                                'Error');
                        }
                    }
                });
                
            });
            $('.modal-close').on('click', function() {
                    $('#modal_add').modal('hide');
                });
        });
    </script>
    {{-- add man power --}}
    {{-- edit man power --}}
    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('manpowerEditContent') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal_edit').modal('show');
                        $('#modal_edit_content').html(response);
                        $('.modal-close').on('click', function() {
                            $('#modal_edit').modal('hide');
                        });
                        $('#UpdateManpower').on('click', function(e) {
                            e.preventDefault();
                            let formData = $('#manpowerFormUpdate').serialize();
                            $.ajax({
                                url: "{{ route('manpowerUpdate') }}",
                                type: "POST",
                                data: formData,
                                success: function(response) {
                                    $('#modal_edit').modal('hide');
                                    
                                    let formatted_date = moment(response.manpower.date).format('YYYY-MM-DD');
                                    
                                    let updatedRow = `
                                        <tr id="manpower-row-${response.manpower.id}">
                                            <td>${response.manpower.id}</td>
                                            <td>${response.manpower.shift.name}</td>
                                            <td>${formatted_date}</td>
                                            <td>${response.manpower.count}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-btn" data-id="${response.manpower.id}"
                                                    data-shift-id="${response.manpower.shift_id}" data-count="${response.manpower.count}"
                                                    data-date="${formatted_date}">
                                                    Edit
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" data-id="${response.manpower.id}"
                                                    data-shift-id="${response.manpower.shift_id}" data-count="${response.manpower.count}"
                                                    data-date="${formatted_date}">Delete</button>
                                            </td>
                                        </tr>
                                    `;
                                    
                                    // Replace the existing row with the updated data
                                    $(`#manpower-row-${response.manpower.id}`).replaceWith(updatedRow);
                                    
                                    if (response.success) {
                                        toastr.success(response.success);
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                        toastr.error(xhr.responseJSON.error, 'Error');
                                    } else {
                                    
                                }}
                            })
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        } else {
                            toastr.error('An error occurred while processing your request.',
                                'Error');
                        }
                    }
                })
                $('.modal-close').on('click', function() {
                    $('#modal_add').modal('hide');
                });
            });
        });
    </script>
    {{-- edit man power --}}
    {{-- Delete man power --}}
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                // Show confirmation dialog
            var confirmation = confirm('Are you sure you want to delete this data?');
            
            if (confirmation) {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('manpowerDelete') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        $(`#manpower-row-${response.manpower.id}`).remove();
                        if (response.success) {
                            toastr.success(response.success);
                            setTimeout(function() {
                                location.reload();
                            }, 2000); 
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        } else {
                            toastr.error('An error occurred while processing your request.',
                                'Error');
                        }
                    }
                })
            }
            });
        });
    </script>
    {{-- Delete man power --}}
@endsection
