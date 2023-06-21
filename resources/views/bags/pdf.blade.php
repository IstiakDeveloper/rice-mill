<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bags and Payments - PDF</title>
    <style>
        /* Add your custom styling for the PDF here */
    </style>
</head>
<body>
    <h1>Bags and Payments</h1>

    <h2>Customer Information:</h2>
    <p>Name: {{ $customer->name }}</p>
    <p>Area: {{ $customer->area }}</p>

    <h2>Bags:</h2>
    @php
        $subtotal = 0;
    @endphp
    @forelse ($customer->bags as $bag)
        <div>
            <p>Amount of Bag: {{ $bag->bag_amount }}</p>
            <p>Bag Size: {{ $bag->bag_size }}</p>
            <p>Per Bag Price: BDT {{ $bag->per_bag_price }}</p>
            <p>Date: {{ $bag->date }}</p>
            @php
                $subTotal = $bag->bag_amount * $bag->per_bag_price;
                $subtotal += $subTotal;
            @endphp
            <p>Sub-total: BDT {{ $subTotal }}</p>
        </div>
        <hr>
    @empty
        <p>No bags found.</p>
    @endforelse

    <h2>Payments:</h2>
    @forelse ($customer->payments as $payment)
        <div>
            <p>Amount: BDT {{ $payment->amount }}</p>
            <p>Date: {{ $payment->date }}</p>
        </div>
        <hr>
    @empty
        <p>No payments found.</p>
    @endforelse

    <h2>Total: BDT {{ $subtotal - $customer->payments->sum('amount') }}</h2>
</body>
</html>
