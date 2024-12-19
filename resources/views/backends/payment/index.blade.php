@extends('backends.master')
@section('title', 'Payments Management')
@section('contents')

    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Payments Management</label>
            <a class="btn btn-primary float-right text-uppercase btn-sm btn-modal btn-add"
                data-href="{{ route('payments.create') }}" data-toggle="modal" data-container=".createPaymentModal">
                {{ __('Add New') }}
            </a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>User</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Payment Type</th>
                        <th>Month Paid</th>
                        <th>Year Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="mb-1">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editpaymentmodal-{{ $payment->id }}">
                                                <i class="fa fa-edit"> @lang('Edit')</i>
                                            </a>
                                        </li>
                                        @if ($payment->type == 'advance')
                                            <li class="mb-1">
                                                <a class=" dropdown-item btn-modal btn-add" data-bs-toggle="modal"
                                                    data-bs-target="#utility_list_modal-{{ $payment->id }}">
                                                    <i class="fas fa-file-alt"></i> @lang('Utilities Payment')
                                                </a>
                                            </li>
                                        @endif
                                        <li class="mb-1">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-file-alt"></i> @lang('Print Invoice')
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('payments.destroy', ['payment' => $payment->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=" dropdown-item text-danger btn delete-btn">
                                                    <i class="fa fa-trash"> @lang('Delete')</i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                @if ($payment->payment_status == 'completed')
                                    <a href="#" class="btn btn-success btn-sm">@lang('Completed')</a>
                                @elseif($payment->payment_status == 'partial')
                                    <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#add_payment_due-{{ $payment->id }}">@lang('Partial')</a>
                                @else
                                    <a href="#" class="btn btn-warning btn-sm">@lang('Pending')</a>
                                @endif
                            </td>
                            <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td>{{ @$payment->userContract->user->name }} ({{ @$payment->userContract->room->room_number }})
                            </td>
                            <td>$ {{ $payment->total_amount }}</td>
                            <td>$ {{ $payment->amount }}</td>
                            <td>$ {{ $payment->total_due_amount ?? '--' }}</td>
                            <td>{{ Str::upper($payment->type) }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade createPaymentModal" id="createPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="createPaymentModalLabel" aria-hidden="true">
        {{-- Modal Create Payment --}}
    </div>
    <div class="modal fade add_uitlity_payment" id="add_uitlity_payment" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="add_uitlity_paymentLabel" aria-hidden="true">
        {{-- Modal Utility Payment --}}
    </div>

    @include('backends.payment.edit')
    @include('backends.payment.partial.add_payment_due')
    @include('backends.payment.partial._list_utilities')
@endsection
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
