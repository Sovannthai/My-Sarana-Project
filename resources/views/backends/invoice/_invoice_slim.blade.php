<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Room Rental Invoice')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .invoice-header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
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

        @media print {
            @page {
                size: auto;
                margin: 10mm;
            }

            body {
                background-color: transparent;
                margin: 0;
            }

            .invoice-container {
                border: none;
                box-shadow: none;
                width: auto;
            }

            .invoice-header {
                background-color: #333 !important;
                color: white !important;
            }

            .invoice-table th,
            .invoice-table td {
                font-size: 12px;
            }
            .footer-invoice{
                margin-top: 40px;
                text-align: center;
            }

            .no-print {
                display: none;
            }

            img {
                display: block !important;
            }
        }

        @media print and (min-width: 210mm) {
            .invoice-container {
                transform: scale(0.95);
                transform-origin: top left;
            }
        }

        @media print and (min-width: 8.5in) and (max-width: 11in) {
            .invoice-container {
                transform: scale(0.9);
                transform-origin: top left;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px; margin-top:20px;margin-left:10px;">
        <button onclick="window.print()">@lang('Print Invoice')</button>
    </div>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="text-uppercase">@lang('Invoice')</h1>
        </div>
        <div class="row">
            <div class="invoice-details" style="width: 50%; float: left;">
                <p><strong>@lang('Invoice No'):</strong> #{{ $invoiceData->invoice_no }}</p>
                <p><strong>@lang('Landlord'):</strong> Pheakdey</p>
            </div>
            <div class="invoice-details" style="width: 50%; float: right;">
                <p><strong>@lang('Date'):</strong> {{ $invoiceData->created_at }}</p>
                <p><strong>@lang('Customer'):</strong> {{ $user->name }}</p>
            </div>
        </div>
        <div style="clear: both;"></div>
        <table class="invoice-table nowrap">
            <tr>
                <th>@lang('Room Details')</th>
                <th>@lang('Rental Period')</th>
                <th>@lang('Rate')</th>
                <th>@lang('Total')</th>
            </tr>
            <tr>
                <td><strong>@lang('Room'):</strong> {{ @$invoiceData->userContract->room->room_number }}
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
                <td colspan="3" style="text-align: right;"><strong>@lang('Subtotal')</strong></td>
                <td>$ {{ number_format($totalRoomPrice, 2) }}</td>
            </tr>
            @if ($invoiceData->paymentUtilities)
            @foreach ($invoiceData->paymentUtilities as $utility)
            <tr>
                <td colspan="2" style="text-align: right;"><strong>{{ @$utility->utility->type }}</strong>
                </td>
                <td>{{ $utility->usage }} ($ {{ number_format($utility->rate_per_unit, 2) }})</td>
                <td>$ {{ number_format($utility->total_amount, 2) }}</td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="3" style="text-align: right;"><strong>@lang('Total Amount')</strong></td>
                <td>$ {{ number_format($invoiceData->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>@lang('Amount Paid')</strong></td>
                <td>$ {{ number_format($invoiceData->amount, 2) }}</td>
            </tr>
            @if ($invoiceData->total_due_amount)
            <tr>
                <td colspan="3" style="text-align: right;"><strong>@lang('Due Amount')</strong></td>
                <td>$ {{ number_format($invoiceData->total_due_amount, 2) }}</td>
            </tr>
            @endif
        </table>
        {{-- <div class="row flex-between">
            <div>
                <div style="margin-top: 10px;" class="float-right">
                    <strong>Exchange Rate:</strong><span> $1.00 (4000.00 Riel)</span>
                </div>
            </div>
        </div> --}}
        <div class="mt-5 footer-invoice">
            <strong>@lang('Thank you for choosing our room rental services')..!</strong>
        </div>
    </div>
</body>

</html>
