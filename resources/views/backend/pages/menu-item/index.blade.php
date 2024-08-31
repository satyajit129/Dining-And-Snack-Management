@extends('backend.global.master')

@section('title', 'Menu Item Index')
@section('heading', 'Menu Item Index')


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
                    <h2>Menu Item Index</h2>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                        Add Menu Item
                    </button>
                </div>
                <div class="card-body">

                    <table class="table" id="MenuItemFormtable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Assigned In</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menu_items as $menu_item)
                                <tr id="menu-item-row-{{ $menu_item->id }}">
                                    <td >{{ $loop->iteration }}</td>
                                    <td>{{ $menu_item->menu->type }}</td>
                                    <td>{{ $menu_item->item_name }}</td>
                                    <td>{{ $menu_item->quantity_per_person }}
                                        @if ($menu_item->in_grams == '2')
                                            <span class="text-danger">(grams)</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($menu_item->menu_assignment == '1')
                                        {{ 'Daily' }}
                                            @else
                                        {{ 'Weekly' }}
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $menu_item->id }}"
                                            data-type="{{ $menu_item->type }}" data-name="{{ $menu_item->name }}"
                                            data-quantity="{{ $menu_item->quantity }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-btn"
                                            data-id="{{ $menu_item->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        {{-- Add Modal --}}
        <x-modal id="modal_add" labelledby="addMenuItemLabel" title="Add Menu Item">
            <form id="menuItemForm" method="POST">
                @csrf
                <x-select name="menu_id" class="form-control" id="menu_id" label="Menu">
                    <option selected disabled>Select Menu</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->type }}</option>
                    @endforeach
                </x-select>
                <x-input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}"
                    placeholder="Item Name" label="Item Name" />
                <div class="form-group col-md-12 mb-4">
                    <label class="text-dark font-weight-medium" for="">Quantity Per Person <span
                            class="text-danger">(If the quentity count in Gram please check the checkbox)</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <label class="control control-checkbox d-inline-block mb-0">
                                    <input id="in_grams" type="checkbox" name="in_grams" value="2" />
                                    <div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                        <input id="quantity_per_person" name="quantity_per_person" type="number" class="form-control"
                            aria-label="Text input with checkbox">
                    </div>
                </div>
                <x-select name="menu_assignment" class="form-control" id="menu_assignment" label="Menu Assignment">
                    <option selected disabled>Select Menu Assignment</option>
                    <option value="1">Daily</option>
                    <option value="2">Weekly</option>
                </x-select>
            </form>

            <x-slot name="footer">
                <button type="button" id="submitMenuItemForm" class="btn btn-primary">Save changes</button>
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
    {{-- add Menu Item --}}
    <script>
        $(document).ready(function() {
            $('#submitMenuItemForm').on('click', function(e) {
                e.preventDefault();

                let formData = $('#menuItemForm').serialize();
                // console.log(formData);

                $.ajax({
                    url: "{{ route('menuItemStore') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('#modal_add').modal('hide');
                        if (response) {
                            let rowCount = $('#MenuItemFormtable tr')
                                .length; // Replace 'your-table-id' with your actual table's ID
                            let newIndex = rowCount;
                            // Conditional logic for in_grams
                            let quantityInfo = response.menu_item.in_grams == '2' ?
                                `<span class="text-danger">(grams)</span>` :
                                '';
                            let menuAssignmentInfo = response.menu_item.menu_assignment == '1' ?
                                'Daily' :
                                'Weekly';


                            let newRow = `
                                <tr>
                                    <td>${newIndex}</td>
                                    <td>${response.menu_item.menu.type}</td>
                                    <td>${response.menu_item.item_name}</td>
                                    <td>${response.menu_item.quantity_per_person} ${quantityInfo}</td>
                                    <td>${menuAssignmentInfo}</td>
                                    <td><button class="btn btn-warning btn-sm">Edit</button></td>
                                    <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                            `;
                            $('#MenuItemFormtable').append(newRow);
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
    {{-- add Menu Item --}}
    {{-- edit Menu Item --}}
    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('menuItemEditContent') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal_edit').modal('show');
                        $('#modal_edit_content').html(response);

                        // Ensure form submission is handled properly
                        $('#UpdateMenuItem').on('click', function(e) {
                            event.preventDefault();

                            let formData = $('#menuItemFormUpdate').serialize();
                            $.ajax({
                                url: "{{ route('menuItemUpdate') }}",
                                type: "POST",
                                data: formData,
                                success: function(response) {
                                    if (response) {
                                        let rowCount = $(
                                                '#MenuItemFormtable tr')
                                            .length;
                                        let newIndex = rowCount +
                                        1;

                                        let quantityInfo = response
                                            .menu_item.in_grams == '2' ?
                                            `<span class="text-danger">(grams)</span>` :
                                            '';
                                        let menuAssignmentInfo = response
                                            .menu_item.menu_assignment == '1' ?
                                            'Daily' :
                                            'Weekly';

                                        let updatedRow = `
                                            <tr>
                                                <td>${response.menu_item.id}</td>
                                                <td>${response.menu_item.menu.type}</td>
                                                <td>${response.menu_item.item_name}</td>
                                                <td>${response.menu_item.quantity_per_person} ${quantityInfo}</td>
                                                <td>${menuAssignmentInfo}</td>
                                                <td><button class="btn btn-warning btn-sm edit-btn" data-id="${response.menu_item.id}">Edit</button></td>
                                                <td><button class="btn btn-danger btn-sm delete-btn" data-id="${response.menu_item.id}">Delete</button></td>
                                            </tr>
                                        `;
                                        $(`#menu-item-row-${response.menu_item.id}`).replaceWith(updatedRow);
                                        toastr.success(response.success);
                                        $('#modal_edit').modal('hide');
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);

                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('#modal_edit').modal('hide');
                                    if (xhr.responseJSON && xhr.responseJSON
                                        .error) {
                                        toastr.error(xhr.responseJSON.error,
                                            'Error');
                                    } else {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                }
                            });
                        });

                        // Close modal
                        $('.modal-close').on('click', function() {
                            $('#modal_edit').modal('hide');
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
                });
            });
        });
    </script>

    {{-- edit Menu Item  --}}
    {{-- Delete Menu Item --}}
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                // Show confirmation dialog
                var confirmation = confirm('Are you sure you want to delete this data?');
                if (confirmation) {
                    $.ajax({
                        url: "{{ route('menuItemDelete') }}",
                        type: "GET",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                            $(`#menu-item-row-${response.menu_item.id}`).remove();
                            if (response) {
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
                    });
                }
            });
        });
    </script>
    {{-- Delete Menu Item --}}
@endsection
