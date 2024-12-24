<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .invoice-container {
        max-width: 595px;
        /* A5 size width */
        margin: auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .invoice-header {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    .invoice-details p {
        margin-bottom: 10px;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-table th,
    .invoice-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .invoice-table th {
        background-color: #f0f0f0;
    }

    .invoice-footer {
        margin-top: 20px;
        text-align: center;
    }

    /* Print media styling */
    @media print {
        body {
            background-color: transparent;
            margin: 0;
        }

        .invoice-container {
            max-width: 100%;
            padding: 0;
            box-shadow: none;
            border: none;
            page-break-inside: avoid;
        }

        .invoice-table th,
        .invoice-table td {
            font-size: 12px;
            width: 100%;
        }

        .invoice-header {
            background-color: #333 !important;
            color: white !important;
        }
    }

    .flex-between {
        display: flex;
        justify-content: space-between;
    }

    .footer-invoice {
        margin-top: 20px;
        text-align: center;
        font-size: 18px;
    }
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Payment Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="invoice-container">
                <div class="invoice-header">
                    <h1 class="text-uppercase">Invoice</h1>
                </div>
                <div class="row">
                    <div class="invoice-details" style="width: 50%; float: left;">
                        <p><strong>Invoice No:</strong> #{{ $invoiceData->invoice_no }}</p>
                        <p><strong>Landlord:</strong> Pheakdey</p>
                    </div>
                    <div class="invoice-details" style="width: 50%; float: right;">
                        <p><strong>Date:</strong> {{ $invoiceData->created_at }}</p>
                        <p><strong>Customer:</strong> {{ $user->name }}</p>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <table class="invoice-table nowrap">
                    <tr>
                        <th>Room Details</th>
                        <th>Rental Period</th>
                        <th>Rate</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td><strong>Room:</strong> {{ @$invoiceData->userContract->room->room_number }}
                            @if ($invoiceData->paymentAmenities)
                            <div style="margin-left: 15px;">
                                @foreach ($invoiceData->paymentAmenities as $amenity)
                                <li>{{ $amenity->amenity->name }}</li>
                                @endforeach
                            </div>
                            @endif
                        </td>
                        @if ($invoiceData->type == 'advance')
                        <td>{{ $invoiceData->start_date }} - {{ $invoiceData->end_date }}</td>
                        @endif
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
                        @if($invoiceData->type != 'advance')
                        <td>{{ $invoiceData->month_paid ? $months[$invoiceData->month_paid] : '-' }}
                            ({{ $invoiceData->year_paid }})</td>
                        @endif
                        <td>$ {{ number_format($invoiceData->total_amount_before_discount, 2) }}</td>
                        <td>$ {{ number_format($invoiceData->total_amount_before_discount, 2) }}</td>
                    </tr>
                    {{-- Discount --}}
                    @if ($invoiceData->total_discount > 0)
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Discount</strong></td>
                        <td>
                            @if ($invoiceData->discount_type == 'amount')
                            <span>$</span> {{ $invoiceData->total_discount }}
                            @else
                            <span>%</span> {{ $invoiceData->total_discount }}
                            @endif
                        </td>
                    </tr>
                    @endif
                    {{-- Total Room Price --}}
                    <?php
                        $totalRoomPrice = 0;
                        if (@$invoiceData->discount_type == 'amount') {
                            $totalRoomPrice = $invoiceData->total_amount_before_discount - $invoiceData->total_discount;
                        } elseif (@$invoiceData->discount_type == 'percentage') {
                            $totalRoomPrice = $invoiceData->total_amount_before_discount - ($invoiceData->total_amount_before_discount * $invoiceData->total_discount) / 100;
                        } else {
                            $totalRoomPrice = $invoiceData->total_amount_before_discount;
                        }
                        ?>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
                        <td>$ {{ number_format($totalRoomPrice, 2) }}</td>
                    </tr>
                    <!-- Electricity Charges -->
                    {{-- @dd($invoiceData->paymentUtilities) --}}
                    @if($invoiceData->type != 'advance')
                        @if ($invoiceData->paymentUtilities)
                            @foreach ($invoiceData->paymentUtilities as $utility)
                                <tr>
                                    <td colspan="2" style="text-align: right;"><strong>{{ @$utility->utility->type }}</strong></td>
                                    <td>{{ $utility->usage }} ($ {{ number_format($utility->rate_per_unit, 2) }})</td>
                                    <td>$ {{ number_format($utility->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    <!-- Total Amount -->
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total Amount</strong></td>
                        <td>$ {{ number_format($invoiceData->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Amount Paid</strong></td>
                        <td>$ {{ number_format($invoiceData->amount, 2) }}</td>
                    </tr>
                    @if ($invoiceData->total_due_amount)
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Due Amount</strong></td>
                        <td>$ {{ number_format($invoiceData->total_due_amount, 2) }}</td>
                    </tr>
                    @endif
                </table>
                <div class="row flex-between">
                    <div style=" float: right;">
                        <div style="margin-top: 10px;">
                            <strong>Exchange Rate:</strong><span> $1.00 (4000.00 Riel)</span>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="mt-3 footer-invoice">
                    <strong>Thank you for choosing our room rental services!</strong>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-dark float-right" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
