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
                    <a href="{{ route('shiftWiseMenuCreate') }}" class="btn btn-primary">
                        Add Shift Wise Menu
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Shift Name</th>
                                <th>Menu Type</th>
                                <th>Time of Day</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shift_wise_menus as $shift_wise_menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $shift_wise_menu->shift->name }}</td>
                                    <td>{{ $shift_wise_menu->menu->type }}</td>
                                    <td>{{ $shift_wise_menu->time_of_day ?? 'N/A' }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary btn-pill" href="{{ route('shiftWiseMenuEditContent', $shift_wise_menu->id) }}">Edit</a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm btn-pill delete-btn" data-id="{{ $shift_wise_menu->id }}" data-toggle="modal" data-target="#deleteModal">
                                            Delete
                                        </a>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

    </div>
@endsection



@section('backend_custom_js')
<script>
    $(document).ready(function() {
        var deleteUrl = ''; 
        var deleteId = null;

        // Trigger the modal with the correct data
        $('.delete-btn').on('click', function() {
            deleteId = $(this).data('id');
            deleteUrl = "{{ route('shiftWiseMenuDelete', ':id') }}".replace(':id', deleteId);
        });

        // Handle the delete confirmation
        $('#confirmDelete').on('click', function() {
            window.location.href = deleteUrl;
        });
    });
</script>
@endsection
