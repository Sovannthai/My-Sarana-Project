@extends('backends.master')
@section('title', 'Expense Categories')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Expense Categories</label>
            <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
                data-bs-target="#addExpenseCategoryModal">
                <i class="fas fa-plus"> @lang('Add')</i>
            </a>
            @include('backends.expense_category.create')
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Icon')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($expenseCategories)
                        @foreach ($expenseCategories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($category->icon)
                                    {{  $category->icon }}
                                    @else
                                        @lang('Not Set')
                                    @endif
                                </td>
                                <td>{{ $category->title }}</td>
                                <td>
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')" data-bs-toggle="modal"
                                        data-bs-target="#editExpenseCategory-{{ $category->id }}">
                                        <i class="fa fa-edit ambitious-padding-btn text-uppercase">@lang('Edit')</i>
                                    </a>&nbsp;&nbsp;
                                    <form id="deleteForm" action="{{ route('expense_categories.destroy', ['expense_category' => $category->id]) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                            title="@lang('Delete')">
                                            <i class="fa fa-trash ambitious-padding-btn text-uppercase">@lang('Delete')</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @include('backends.expense_category.edit')
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
