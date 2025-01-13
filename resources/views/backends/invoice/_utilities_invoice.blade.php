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
</head>

<body>
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
                <p><strong>@lang('Room'):</strong> {{ @$invoiceData->userContract->room->room_number  }}</p>
            </div>
        </div>
        <div style="clear: both;"></div>
        <table class="invoice-table nowrap">
            <tr>
                <th>@lang('Utility Type')</th>
                <th>@lang('Usage')</th>
                <th>@lang('Rate')</th>
                <th>@lang('Total')</th>
            </tr>
            @if ($invoiceData->paymentUtilities)
            @foreach ($invoiceData->paymentUtilities as $utility)
            <tr>
                <td><strong>{{ @$utility->utility->type }}</strong></td>
                <td>{{ $utility->usage }}</td>
                <td>$ {{ number_format($utility->rate_per_unit, 2) }}</td>
                <td>$ {{ number_format($utility->total_amount, 2) }}</td>
            </tr>
            @endforeach
            @endif
            <!-- Total Amount -->
            <?php
                $totalAmount = 0;
                foreach ($invoiceData->paymentUtilities as $utility) {
                    $totalAmount += $utility->total_amount;
                }
            ?>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>@lang('Total Amount')</strong></td>
                <td>$ {{ number_format($totalAmount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>@lang('Amount Paid')</strong></td>
                <td>$ {{ number_format($totalAmount, 2) }}</td>
            </tr>
            {{-- @if ($invoiceData->total_due_amount)
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Due Amount</strong></td>
                <td>$ {{ number_format($invoiceData->total_due_amount, 2) }}</td>
            </tr>
            @endif --}}
        </table>
        <div class="row flex-between">
            <div style="width: 50%; float: left; text-align: center;">
                <strong>ABA QR:</strong><br>
                <img src="{{ public_path('uploads/all_photo/qr.png') }}" alt="ABA QR Code" style="width: 120px; height: 120px;">
            </div>
            <div style="width: 50%; float: right;">
                <div style="margin-top: 10px;">
                    <strong>@lang('Exchange Rate'):</strong><span> $1.00 (4000.00 Riel)</span>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="mt-3 footer-invoice">
            <strong>@lang('Thank you for choosing our room rental services')..!</strong>
        </div>
    </div>
</body>

</html>
