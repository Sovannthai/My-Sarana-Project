<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Rental Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            max-width: 595px; /* A5 size width */
            margin: 40px auto;
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
        .footer-invoice{
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="text-uppercase">Invoice</h1>
        </div>
        <div class="row">
            <div class="invoice-details" style="width: 50%; float: left;">
                <p><strong>Invoice No:</strong> #INV001</p>
                <p><strong>Landlord:</strong> Pheakdey</p>
            </div>
            <div class="invoice-details" style="width: 50%; float: right;">
                <p><strong>Date:</strong> 2023-02-20</p>
                <p><strong>Customer:</strong> {{ $user->name }}</p>
            </div>
        </div>
        <div style="clear: both;"></div>
        <table class="invoice-table">
            <tr>
                <th>Room Details</th>
                <th>Rental Period</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Room 101 (Single)</td>
                <td>2023-02-15 - 2023-02-20</td>
                <td>$100.00</td>
                <td>$500.00</td>
            </tr>
            <!-- Electricity Charges -->
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Electricity Charges (KW)</strong></td>
                <td>50 KW ($1.00/KW)</td>
                <td>$50.00</td>
            </tr>
            <!-- Water Supply Charges with Usage -->
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Water Supply (Cubic Meters)</strong></td>
                <td>15 m³ ($2.00/m³)</td>
                <td>$30.00</td>
            </tr>
            <!-- Amenities with Type -->
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Amenities</strong></td>
                <td>Wi-Fi, Gym Access</td>
                <td>$15.00</td>
            </tr>
            <!-- Trash Disposal -->
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Trash Disposal</strong></td>
                <td>$20.00</td>
            </tr>
            <!-- Total Amount -->
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total Amount</strong></td>
                <td>$615.00</td>
            </tr>
        </table>
        <div class="row flex-between">
            <div style="width: 50%; float: left; text-align: center;">
                <strong>ABA QR:</strong><br>
                <img src="{{ public_path('uploads/all_photo/qr.png') }}" alt="ABA QR Code"
                     style="width: 120px; height: 120px;">
            </div>
            <div style="width: 50%; float: right;">
                <div style="margin-top: 20px;">
                    <strong>Payment Method:</strong><span> ABA</span>
                </div>
                <div style="margin-top: 10px;">
                    <strong>Exchange Rate:</strong><span> $1.00 (4000.00 Riel)</span>
                </div>
                <div style="margin-top: 10px;">
                    <strong>Amount Paid:</strong><span> $615.00</span>
                </div>
                <div style="margin-top: 10px;">
                    <strong>Payment Status:</strong><span> Paid</span>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="mt-3 footer-invoice">
            <strong>Thank you for choosing our room rental services!</strong>
        </div>
    </div>
</body>

</html>
