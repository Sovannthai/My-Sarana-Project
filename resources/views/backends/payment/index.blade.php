@extends('backends.master')
@section('title', 'Payments Management')
@section('contents')

    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Payments Management</label>
            <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#createPaymentModal">
                <i class="fas fa-plus"> @lang('Add Payment')</i>
            </a>
            @include('backends.payment.create')
        </div>

        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Tenant</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Payment Type</th>
                        <th>Payment Date</th>
                        <th>Month Paid</th>
                        <th>Year Paid</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->userContract->user->name }}</td>
                            <td>$ {{ $payment->total_amount }}</td>
                            <td>$ {{ $payment->amount }}</td>
                            <td>$ {{ $payment->total_due_amount ?? '--' }}</td>
                            <td>{{ Str::upper($payment->type) }}</td>
                            <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '-' }}
                            </td>
                            @php
                                $months = [
                                    1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December',
                                ];
                            @endphp
                            <td>{{ $payment->month_paid ? $months[$payment->month_paid] : '-' }}</td>
                            <td>{{ $payment->year_paid ?? '-' }}</td>
                            <td>
                                @if ($payment->payment_status == 'completed')
                                    <span class="badge bg-success">@lang('Completed')</span>
                                @elseif($payment->payment_status == 'partial')
                                    <span class="badge bg-info">@lang('Partial')</span>
                                @else
                                    <span class="badge bg-warning">@lang('Pending')</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPaymentModal-{{ $payment->id }}">
                                    <i class="fa fa-edit">@lang('Edit')</i>
                                </a>
                                <form action="{{ route('payments.destroy', ['payment' => $payment->id]) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete-btn">
                                        <i class="fa fa-trash">@lang('Delete')</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @include('backends.payment.edit')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
