@extends('backends.master')
@section('title', 'Price Adjustments')
@section('contents')
<style>
    #filter-room {
        margin-right: 10px;
        min-width: 200px;
    }
</style>
<div class="card">
    <h5 class=" ml-3 mt-2 mb-0 card-title">
        <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example"
            id="heading-example" class="d-block bg-success-header">
            <i class="fa fa-filter bg-success-header"></i>
            @lang('Filter')
        </a>
    </h5>
    <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
        <div class="mt-1 ml-3 mb-4">
            <div class="row">
                <div class="col-sm-4">
                    <label for="room_id">@lang('Room')</label>
                    <select id="filter-room" class="form-control select2">
                        <option value="">@lang('Filter by Room')</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">Price Adjustments</label>
        <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
            data-bs-target="#create_price">
            <i class="fas fa-plus"> @lang('Add')</i></a>
        @include('backends.price_adjustment.create')
    </div>
    <div class="card-body">
        <table id="discount-table" class="table table-bordered text-nowrap table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Room</th>
                    <th>Discount Type</th>
                    <th>Discount Value(%)</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @include('backends.price_adjustment.edit') --}}
            </tbody>
        </table>
        <div class="modal fade edit_duscount_modal" id="edit_duscount_modal" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_duscount_modalLabel" aria-hidden="true">
            {{-- Modal Utility Payment --}}
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".btn-modal", function(e) {
        e.preventDefault();
        var container = $(this).data("container");
        console.log(1);

        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function(result) {
                $(container).html(result).modal("show");
            },
        });
    });
</script>
<script>
    $(document).ready(function () {
        function route(name, parameter) {
        const routes = {
            'price_adjustments.edit': '{{ route('price_adjustments.edit', ':id') }}'
        };

        return routes[name].replace(':id', parameter);
    }
        const table = $("#discount-table").DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            paging: true,
            searching: true,
            ordering: true,
            ajax: {
                url: "{{ route('price_adjustments.index') }}",
                data: function (d) {
                    d.room_id = $("#filter-room").val();
                },
            },
            columns: [
                { data: "id", name: "id", render: (data, type, row, meta) => meta.row + 1 },
                { data: "room.room_number", name: "room.room_number" },
                { data: "discount_type", name: "discount_type" },
                {
                    data: "discount_value",
                    name: "discount_value",
                    render: function (data, type, row) {
                        return row.discount_type === "amount" ? data + " $" : data + " %";
                    },
                },
                { data: "description", name: "description" },
                { data: "start_date", name: "start_date" },
                { data: "end_date", name: "end_date" },
                {
                    data: "status",
                    name: "status",
                    render: function (data) {
                        return data === "active"
                            ? '<span class="badge bg-success">@lang("Active")</span>'
                            : '<span class="badge bg-danger">@lang("Inactive")</span>';
                    },
                },
                {
                    data: "id",
                    name: "id",
                    render: function (data, type, row) {
                    return `
                        <a href="" class="btn btn-outline-primary btn-sm text-uppercase btn-modal btn-add" data-href="${route('price_adjustments.edit', data)}" data-toggle="modal" data-container=".edit_duscount_modal">
                            <i class="fa fa-edit">@lang("Edit")</i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm text-uppercase delete-button" data-id="${data}">
                            <i class="fa fa-trash">@lang("Delete")</i>
                        </button>`;
                    },
                },
            ],
            language: {
                search: "@lang('Search'):",
                lengthMenu: "@lang('Show _MENU_ entries')",
                info: "@lang('Showing _START_ to _END_ of _TOTAL_ entries')",
                infoEmpty: "@lang('No entries available')",
                paginate: {
                    next: "@lang('Next')",
                    previous: "@lang('Previous')",
                },
            },
        });

        $("#filter-room").on("change", function () {
            table.ajax.reload();
        });
        toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "5000",
        "extendedTimeOut": "2000",
        "positionClass": "toast-top-right"
    };
        $(document).on("click", ".delete-button", function (e) {
            e.preventDefault();
            const button = $(this);
            const priceAdjustmentId = button.data("id");
            var deleteUrl = "{{ route('price_adjustments.destroy', ':id') }}";
            var url = deleteUrl.replace(':id', priceAdjustmentId);

            Swal.fire({
                title: "@lang('Are you sure?')",
                text: "@lang('You won\'t be able to revert this!')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "@lang('Yes, delete it!')",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                        toastr.success('@lang("The record has been deleted.")', '@lang("Deleted!")');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        toastr.error('@lang("There was an error deleting the record.")', '@lang("Error!")');
                    },
                    });
                }
            });
        });
    });
</script>
@endsection
