<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bags and Payments - PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .season-section {
            border: 1px solid #000;
            margin-bottom: 20px;
            padding: 10px;
        }
        .total-section {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Customer Information:</h2>
    <p>Name: {{ $customer->name }}</p>
    <p>Area: {{ $customer->area }}</p>
    @php
        $seasonData = [];
    @endphp

    @foreach ($customer->bags as $bag)
        @php
            $season = $bag->season->name;
        @endphp

        @if (!isset($seasonData[$season]))
            @php
                $seasonData[$season] = [
                    'bags' => [],
                    'payments' => [],
                    'seasonTotal' => 0,
                ];
            @endphp
        @endif

        @php
            $subTotal = $bag->bag_amount * $bag->per_bag_price;
            $seasonData[$season]['seasonTotal'] += $subTotal;
            $seasonData[$season]['bags'][] = [
                'amount' => $bag->bag_amount,
                'size' => $bag->bag_size,
                'price' => $bag->per_bag_price,
                'date' => $bag->date,
                'subTotal' => $subTotal,
            ];
        @endphp
    @endforeach

    @foreach ($customer->payments as $payment)
        @php
            $season = $payment->season->name;
        @endphp

        @if (!isset($seasonData[$season]))
            @php
                $seasonData[$season] = [
                    'bags' => [],
                    'payments' => [],
                    'seasonTotal' => 0,
                ];
            @endphp
        @endif

        @php
            $seasonData[$season]['seasonTotal'] -= $payment->amount;
            $seasonData[$season]['payments'][] = [
                'amount' => $payment->amount,
                'date' => $payment->date,
            ];
        @endphp
    @endforeach

    @foreach ($seasonData as $season => $data)
        <div class="season-section">
            <h3>Season: {{ $season }}</h3>

            @if (!empty($data['bags']))
                <h4>Bags:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount of Bag</th>
                            <th>Bag Size</th>
                            <th>Per Bag Price</th>
                            <th>Sub-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['bags'] as $bag)
                            <tr>
                                <td>{{ $bag['date'] }}</td>
                                <td>{{ $bag['amount'] }}</td>
                                <td>{{ $bag['size'] }}</td>
                                <td>BDT {{ $bag['price'] }}</td>
                                <td>BDT {{ $bag['subTotal'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No bags found for this season.</p>
            @endif

            @if (!empty($data['payments']))
                <h4>Payments:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['payments'] as $payment)
                            <tr>
                                <td>{{ $payment['date'] }}</td>
                                <td>BDT {{ $payment['amount'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No payments found for this season.</p>
            @endif

            <p>Season Total: BDT {{ $data['seasonTotal'] }}</p>
        </div>
    @endforeach

    <div class="total-section">
        <h2>Total Bosta: BDT {{ $customer->bags->sum('bag_amount') }}</h2>
        <h2>Total Amount: BDT {{ $customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }) }}</h2>
        <h2>Total Payment: BDT {{ $customer->payments->sum('amount') }}</h2>
        <h2>Due: BDT {{ $customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }) - $customer->payments->sum('amount') }}</h2>
    </div>
</body>
</html>
