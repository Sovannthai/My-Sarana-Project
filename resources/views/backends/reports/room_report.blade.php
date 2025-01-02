@extends('backends.master')
@section('title', __('Room Report'))
@section('contents')
    <style>
        #filter-room,
        #filter-status,
        #filter-start-date,
        #filter-end-date {
            margin-right: 10px;
            min-width: 200px;
        }
    </style>
    <div class="card">
        <h5 class="ml-3 mt-2 mb-0 card-title">
            <a data-toggle="collapse" href="#collapse-filters" aria-expanded="true" aria-controls="collapse-filters"
                id="heading-filters" class="d-block bg-success-header">
                <i class="fa fa-filter bg-success-header"></i>
                @lang('Filter')
            </a>
        </h5>
        <div id="collapse-filters" class="collapse show" aria-labelledby="heading-filters">
            <div class="mt-1 ml-2 mr-2 mb-4">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="filter-room">@lang('Room')</label>
                        <select id="filter-room" class="form-control select2">
                            <option value="">@lang('Filter by Room')</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-user">@lang('User')</label>
                        <select id="filter-user" class="form-control select2">
                            <option value="">@lang('Filter by User')</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-status">@lang('Status')</label>
                        <select id="filter-status" class="form-control select2">
                            <option value="">@lang('Filter by Status')</option>
                            <option value="active">@lang('Active')</option>
                            <option value="inactive">@lang('Inactive')</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-start-date">@lang('Start Date')</label>
                        <input type="date" id="filter-start-date" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-end-date">@lang('End Date')</label>
                        <input type="date" id="filter-end-date" class="form-control">
                    </div>
                </div>
                <div>
                    <a href="{{ route('reports.room') }}" class="btn btn-outline-danger float-left text-capitalize mb-3 mt-3">Reset Filter</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Room Report')</label>
        </div>
        <div class="card-body">
            <table id="contracts-table" class="table table-bordered text-nowrap table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Room')</th>
                        <th>@lang('User ID')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Size')</th>
                        <th>@lang('Floor')</th>
                        <th>@lang('Monthly Rent')</th>
                        <th>@lang('Start Date')</th>
                        <th>@lang('End Date')</th>
                        <th>@lang('Status')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const table = $("#contracts-table").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('reports.room') }}",
                    data: function(d) {
                        d.user_id = $("#filter-user").val();
                        d.room_id = $("#filter-room").val();
                        d.status = $("#filter-status").val();
                        d.start_date = $("#filter-start-date").val();
                        d.end_date = $("#filter-end-date").val();
                    },
                },
                columns: [{
                        data: "id",
                        name: "id",
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: "room_number",
                        name: "room_number"
                    },
                    {
                        data: "user_name",
                        name: "user_name"
                    },
                    {
                        data: "description",
                        name: "description"
                    },
                    {
                        data: "size",
                        name: "size"
                    },
                    {
                        data: "floor",
                        name: "floor"
                    },
                    {
                        data: "monthly_rent",
                        name: "monthly_rent",
                        render: data => `${data} $`
                    },
                    {
                        data: "start_date",
                        name: "start_date"
                    },
                    {
                        data: "end_date",
                        name: "end_date"
                    },
                    {
                        data: "status",
                        name: "status",
                        render: function(data) {
                            return data === "active" ?
                                '<span class="badge bg-success">@lang('Active')</span>' :
                                '<span class="badge bg-danger">@lang('Inactive')</span>';
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

            // Reload table when filters are applied
            $("#filter-user, #filter-room, #filter-status, #filter-start-date, #filter-end-date").on("change",
                function() {
                    table.ajax.reload();
                });
        });
    </script>
@endsection
