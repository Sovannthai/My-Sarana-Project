@extends('backends.master')
@section('title', 'Expense Transactions')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Expense Transactions</label>
            @can('create expense')
            <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
                data-bs-target="#addExpenseTransactionModal">
                <i class="fas fa-plus"> @lang('Add')</i>
            </a>
            @include('backends.expense_transaction.create')
            @endcan
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
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
                    @if ($expenseTransactions)
                        @foreach ($expenseTransactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->category->title ?? __('N/A') }}</td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->note ?? __('No Note') }}</td>
                                <td>
                                    @can('update expense')
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')" data-bs-toggle="modal"
                                        data-bs-target="#editExpenseTransaction-{{ $transaction->id }}">
                                        <i class="fa fa-edit ambitious-padding-btn text-uppercase">@lang('Edit')</i>
                                    </a>&nbsp;&nbsp;
                                    @endcan
                                    @can('delete expense')
                                    <form id="deleteForm" action="{{ route('expense_transactions.destroy', ['expense_transaction' => $transaction->id]) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                            title="@lang('Delete')">
                                            <i class="fa fa-trash ambitious-padding-btn text-uppercase">@lang('Delete')</i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @include('backends.expense_transaction.edit')
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
