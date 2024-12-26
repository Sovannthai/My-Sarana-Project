@extends('backends.master')
@section('title', 'Utility Report')
@section('contents')
    <style>
        #filter-room,
        #filter-utility,
        #filter-month,
        #filter-year {
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
            <div class="mt-1 ml-3 mb-4">
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
                        <label for="filter-utility">@lang('Utility Type')</label>
                        <select id="filter-utility" class="form-control select2">
                            <option value="">@lang('Filter by Utility Type')</option>
                            @foreach ($utilityTypes as $utilityType)
                                <option value="{{ $utilityType->id }}">{{ $utilityType->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-month">@lang('Month')</label>
                        <select id="filter-month" class="form-control select2">
                            <option value="">@lang('Filter by Month')</option>
                            <option value="1">@lang('Jan')</option>
                            <option value="2">@lang('Feb')</option>
                            <option value="3">@lang('Mar')</option>
                            <option value="4">@lang('Apr')</option>
                            <option value="5">@lang('May')</option>
                            <option value="6">@lang('Jun')</option>
                            <option value="7">@lang('Jul')</option>
                            <option value="8">@lang('Aug')</option>
                            <option value="9">@lang('Sep')</option>
                            <option value="10">@lang('Oct')</option>
                            <option value="11">@lang('Nov')</option>
                            <option value="12">@lang('Dec')</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="filter-year">@lang('Year')</label>
                        <input type="number" id="filter-year" class="form-control" placeholder="@lang('Enter Year')">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Utility Report')</label>
        </div>
        <div class="card-body">
            <table id="utility-table" class="table table-bordered text-nowrap table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Room')</th>
                        <th>@lang('Month')</th>
                        <th>@lang('Year')</th>
                        <th>@lang('Utility Type')</th>
                        <th>@lang('Usage')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const table = $("#utility-table").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('reports.utility') }}",
                    data: function(d) {
                        d.room_id = $("#filter-room").val();
                        d.utility_type_id = $("#filter-utility").val();
                        d.month = $("#filter-month").val();
                        d.year = $("#filter-year").val();
                    },
                },
                columns: [
                    { data: null, name: "id", render: (data, type, row, meta) => meta.row + 1 },
                    { data: "room_number", name: "room_number" },
                    { data: "month", name: "month", render: (data) => {
                        const months = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        return months[data];
                    }},
                    { data: "year", name: "year" },
                    { data: "utility_type", name: "utility_type" },
                    { data: "usage", name: "usage", render: data => `${data} units` },
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


            $("#filter-room, #filter-utility, #filter-month, #filter-year").on("change", function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
