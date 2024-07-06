<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
        }
        .area-section {
            margin-bottom: 15px;
        }
        .area-title {
            font-size: 12px; /* Reduced font size */
            font-weight: bold;
            color: #0056b3;
        }
        .customer-section {
            margin-bottom: 32px;
        }
        .section-title {
            font-size: 14px; /* Reduced font size */
            font-weight: bold;
            color: #333;
        }
        .section-content {
            margin-top: 2px;
        }
        .season-section {
            margin-top: 2px;
            padding: 5px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .season-title {
            font-size: 12px; /* Reduced font size */
            font-weight: bold;
            color: #007bff;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 3px; /* Reduced padding */
            font-size: 10px; /* Smaller font size for table content */
        }
        .table th {
            background-color: #f2f2f2;
        }
        .totals {
            margin-top: 4px;
        }
        .totals p {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
            padding: 5px;
            background-color: #eaeaea;
            border-radius: 3px;
            font-size: 10px;
        }

        .totals p span {
            margin-right: 15px;
        }

        .customer-totals {
            margin-top: 4px;
        }
        .customer-totals p {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
            padding: 5px;
            background-color: #ff0000;
            color: #fff;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .customer-totals p span {
            margin-right: 15px;

        }
        .total-due-overall {
            margin-top: 20px;
            font-size: 12px;
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>
<body>
    @php
        $totalDueOverall = 0;
        $areaWiseCustomers = $customers->groupBy('area');
    @endphp
    @foreach ($areaWiseCustomers as $area => $customers)
        <div class="area-section">
            <div class="area-title">Area: {{ $area }}</div>
            @foreach ($customers as $index => $customer)
                @php
                    $totalCustomerAmount = 0;
                    $totalCustomerPayment = 0;
                    $totalCustomerDue = 0;
                @endphp
                <div class="customer-section">
                    <div class="section-title">{{ $index + 1 }}. {{ $customer->name }}</div>
                    <div class="section-content">
                        @foreach ($customer->bags->unique('season.name') as $bag)
                            @php
                                $seasonKey = $bag->season->name;
                                $seasonBostaTotal = $customer->bags->where('season.name', $seasonKey)->sum('bag_amount');
                                $seasonAmountTotal = $customer->bags->where('season.name', $seasonKey)->sum('total');
                                $seasonPaymentTotal = $customer->payments->where('season.name', $seasonKey)->sum('amount');
                                $seasonDueTotal = $seasonAmountTotal - $seasonPaymentTotal;
                                $totalDueOverall += $seasonDueTotal;
                                $totalCustomerAmount += $seasonAmountTotal;
                                $totalCustomerPayment += $seasonPaymentTotal;
                                $totalCustomerDue += $seasonDueTotal;
                            @endphp

                            <div class="season-section">
                                <div class="season-title">Season: {{ $seasonKey }}</div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Bosta</th>
                                            <th>Bosta Size</th>
                                            <th>Per Bosta Price</th>
                                            <th>Date</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->bags->where('season.name', $seasonKey) as $bosta)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $bosta->bag_amount }}</td>
                                                <td>{{ $bosta->bag_size }}</td>
                                                <td>BDT:  {{ $bosta->per_bag_price }}</td>
                                                <td>{{ $bosta->date }}</td>
                                                <td>BDT:  {{ $bosta->bag_amount * $bosta->per_bag_price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <table class="table mt-4">
                                    <div class="season-title">Payment in: {{ $seasonKey }}</div>
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $seasonPayments = $customer->payments->where('season.name', $seasonKey);
                                        @endphp
                                        @if($seasonPayments->isEmpty())
                                            <tr>
                                                <td colspan="3">No payment available</td>
                                            </tr>
                                        @else
                                            @foreach ($seasonPayments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>BDT:  {{ $payment->amount }}</td>
                                                    <td>{{ $payment->date }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="totals">
                                    <p>
                                        <span>Total Bosta: {{ $seasonBostaTotal }}</span>
                                        <span>Total Amount: BDT: {{ number_format($seasonAmountTotal, 2) }}</span>
                                        <span>Total Payment: BDT: {{ number_format($seasonPaymentTotal, 2) }}</span>
                                        <span>Total Due: BDT: {{ number_format($seasonDueTotal, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="customer-totals">
                        <p>
                            <span>Total Amount: BDT: {{ number_format($totalCustomerAmount, 2) }}</span>
                            <span>Total Payment: BDT: {{ number_format($totalCustomerPayment, 2) }}</span>
                            <span>Total Due: BDT: {{ number_format($totalCustomerDue, 2) }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="total-due-overall">
        Overall Total Due: BDT: {{ number_format($totalDueOverall, 2) }}
    </div>
</body>
</html>
