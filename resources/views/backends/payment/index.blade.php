@extends('backends.master')
@section('title', 'Payments Management')
@section('contents')

<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">Payments Management</label>
        <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal" data-bs-target="#createPaymentModal">
            <i class="fas fa-plus"> @lang('Add Payment')</i>
        </a>
        @include('backends.payment.create')
    </div>

    <div class="card-body">
        <table id="basic-datatables" class="table table-bordered text-nowrap table-hover">
            <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Tenant</th>
                    <th>Amount</th>
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
                        <td>{{ $payment->amount }} {{ $payment->currency ?? 'USD' }}</td>
                        <td>{{ ucfirst($payment->type) }}</td>
                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $payment->month_paid ?? '-' }}</td>
                        <td>{{ $payment->year_paid ?? '-' }}</td>
                        <td>
                            @if($payment->status == 'completed')
                                <span class="badge bg-success">@lang('Completed')</span>
                            @else
                                <span class="badge bg-warning">@lang('Pending')</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPaymentModal-{{ $payment->id }}">
                                <i class="fa fa-edit">@lang('Edit')</i>
                            </a>
                            <form action="{{ route('payments.destroy', ['payment' => $payment->id]) }}" method="POST" class="d-inline-block">
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

