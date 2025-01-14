@extends('backends.master')
@section('title', __('Expenses'))
@section('contents')
<div class="card">
    <h5 class=" ml-3 mt-2 mb-0 card-title">
        <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example"
            id="heading-example" class="d-block bg-success-header">
            <i class="fa fa-filter bg-success-header"></i>
            @lang('Filter')
        </a>
    </h5>
    <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
        <div class="mt-1 ml-2 mr-2 mb-4">
            <div class="row">
                <div class="col-sm-3">
                    <label for="room_id">@lang('Category')</label>
                    <select id="category-filter" class="form-control select2">
                        <option value="">@lang('All Categories')</option>
                        @foreach ($expenseCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="date-filter">@lang('Select Date Range')</label>
                    <select id="date-filter" class="form-control select2">
                        <option value="" selected>@lang('-- Select Range --')</option>
                        <option value="today">@lang('Today')</option>
                        <option value="this_week">@lang('This Week')</option>
                        <option value="this_month">@lang('This Month')</option>
                        <option value="last_month">@lang('Last Month')</option>
                        <option value="this_year">@lang('This Year')</option>
                        <option value="last_year">@lang('Last Year')</option>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="from_date">@lang('From Date')</label>
                    <input type="date" name="from_date" id="from-date-filter" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label for="to_date">@lang('To Date')</label>
                    <input type="date" name="to_date" id="to-date-filter" class="form-control">
                </div>
            </div>
            <div>
                <a href="{{ route('expense_transactions.index') }}" class="btn btn-outline-danger float-right text-uppercase mb-3 mt-3">@lang('Reset Filter')</a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Expense Transactions')</label>
        @can('create expense')
        <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
            data-bs-target="#addExpenseTransactionModal">
            <i class="fas fa-plus"></i> @lang('Add')
        </a>
        @include('backends.expense_transaction.create')
        @endcan
    </div>
    <div class="card-body">
        <table id="expense-table" class="table table-bordered text-nowrap table-hover table-responsive-lg">
            <thead class="table-dark">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Category')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Note')</th>
                    <th>@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be injected here via DataTable -->
            </tbody>
        </table>
        <div class="modal fade edit_expense_modal" id="edit_expense_modal" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_expense_modalLabel" aria-hidden="true">
            {{-- Modal Utility Payment --}}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });
    });
</script>
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
            'expense_transactions.edit': '{{ route('expense_transactions.edit', ':id') }}'
        };

        return routes[name].replace(':id', parameter);
    }
    const table = $("#expense-table").DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        paging: true,
        searching: true,
        ordering: true,
        ajax: {
            url: "{{ route('expense_transactions.index') }}",
            data: function (d) {
                d.category_id = $("#category-filter").val();
                d.from_date = $("#from-date-filter").val();
                d.to_date = $("#to-date-filter").val();
                d.date_range = $("#date-filter").val();
            },
            dataSrc: function (json) {
                return json.expenseTransactions;
            }
        },
        columns: [
            { data: "id", name: "id", render: (data, type, row, meta) => meta.row + 1 },
            { data: "category.title", name: "category.title" },
            { data: "amount", name: "amount" },
            { data: "date", name: "date" },
            { data: "note", name: "note" },
            {
                data: "id",
                name: "id",
                render: function (data) {
                    return `
                    @can('update expense')
                        <a href="#" class="btn btn-outline-primary btn-sm text-uppercase btn-modal btn-add" data-href="${route('expense_transactions.edit', data)}" data-toggle="modal" data-container=".edit_expense_modal">
                            <i class="fa fa-edit"></i> @lang("Edit")
                        </a>
                    @endcan
                    @can('delete expense')
                        <button type="button" class="btn btn-outline-danger btn-sm text-uppercase delete-button" data-id="${data}">
                            <i class="fa fa-trash"></i> @lang("Delete")
                        </button>
                    @endcan`;
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

    $("#category-filter, #date-filter,#from-date-filter, #to-date-filter").on("change", function () {
        table.ajax.reload(); // Reload the DataTable with new filter parameters
    });

    $(document).on("click", ".delete-button", function (e) {
        e.preventDefault();
        const button = $(this);
        const expenseTransactionId = button.data("id");
        var deleteUrl = "{{ route('expense_transactions.destroy', ':id') }}";
        var url = deleteUrl.replace(':id', expenseTransactionId);

        Swal.fire({
            title: "@lang('Are you sure?')",
            text: "@lang('You will not be able to revert this!')",
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
