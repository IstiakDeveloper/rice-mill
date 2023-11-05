@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
        <div class="text-center">
            <img src="{{ $customer->image }}" alt="Profile Picture" class="rounded-full h-24 w-24 mx-auto mb-4">
            <h3 class="text-2xl font-extrabold text-blue-500">{{ $customer->name }}</h3>
            <p class="text-lg text-gray-700">{{ $customer->area }}</p>
            <div class="mt-4">
                <a href="{{ route('bags.pdf', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full">
                    Download PDF
                </a>
            </div>
        </div>

        <div class="p-4">
            <button id="addNewBagButton" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mt-5">
                Add New Bosta
            </button>

            <form id="form1" method="POST" action="{{ route('bags.store', $customer) }}" class="hidden">
                @csrf
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="bag_amount" class="block text-sm font-medium text-gray-700">Koto Bosta</label>
                        <input type="text" id="bag_amount" name="bag_amount" value="{{ old('bag_amount') }}"
                            class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('bag_amount')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="bag_size" class="block text-sm font-medium text-gray-700">Bosta Size</label>
                        <select id="bag_size" name="bag_size"
                            class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                            <option value="">Select Bosta Size</option>
                            <option value="feed">feed</option>
                            <option value="gom">gom</option>
                            <option value="vushi">vushi</option>
                            <option value="gom l">gom l</option>
                        </select>
                        @error('bag_size')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="per_bag_price" class="block text-sm font-medium text-gray-700">Per Bosta Price</label>
                        <input type="number" id="per_bag_price" name="per_bag_price" value="{{ old('per_bag_price') }}"
                            class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('per_bag_price')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" id="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}"
                            class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                        @error('date')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full">Add Bosta</button>
                </div>
            </form>
            <button id="addNewPaymentButton" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mt-5">
                Add New Payment
            </button>
            <form id="paymentForm" method="POST" action="{{ route('bags.pay', $customer) }}" class="hidden">
                @csrf

                <div class="mt-4">
                    <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                    <input type="number" id="payment_amount" name="payment_amount" value="{{ old('payment_amount') }}"
                        class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('payment_amount')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date"
                        value="{{ old('payment_date') ?? date('Y-m-d') }}"
                        class="mt-1 block w-full border border-blue-500 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('payment_date')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full">Pay</button>
                </div>
            </form>
        </div>

        <div class="p-4">
            <h4 class="text-2xl font-extrabold text-blue-500">Seasons</h4>
            @foreach ($customer->bags->unique('season.name') as $bag)
                @php
                    $seasonKey = $bag->season->name;
                    $seasonBostaTotal = $customer->bags->where('season.name', $seasonKey)->sum('bag_amount');
                    $seasonAmountTotal = $customer->bags->where('season.name', $seasonKey)->sum('total');
                    $seasonPaymentTotal = $customer->payments->where('season.name', $seasonKey)->sum('amount');
                @endphp

                <div class="mt-2">
                    <a href="#" class="season-link text-xl font-semibold border-b border-gray-300 pb-2">
                        <span class="season-icon">&#9662;</span> Season: {{ $seasonKey }}
                    </a>

                    <div class="season-details hidden">
                        @foreach ($customer->bags->where('season.name', $seasonKey) as $bosta)
                            <div class="flex justify-between items-center mt-2 bg-gray-100 p-4 rounded-lg">
                                <div>
                                    <p class="text-lg font-semibold">Bosta Details</p>
                                    <div class="text-blue-500">
                                        <p class="mt-2">Bosta: {{ $bosta->bag_amount }}</p>
                                        <p>Bosta Size: {{ $bosta->bag_size }}</p>
                                        <p>Per Bosta Price: &#2547;{{ $bosta->per_bag_price }}</p>
                                        <p>Date: {{ $bosta->date }}</p>
                                        @php
                                        $subTotal = $bosta->bag_amount * $bosta->per_bag_price;
                                        @endphp
                                        <p class="text-right mt-4">Sub-total: &#2547;{{ $subTotal }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        @endforeach

                        <h5 class="text-xl font-semibold mt-2 text-blue-500">Payments for {{ $seasonKey }}</h5>

                        @foreach ($customer->payments->where('season.name', $seasonKey) as $payment)
                            <div class="flex justify-between items-center mt-2">
                                <div>
                                    <p class="text-blue-500">Amount: &#2547;{{ $payment->amount }}</p>
                                    <p>Date: {{ $payment->date }}</p>
                                </div>
                            </div>
                            <hr class="my-2">
                        @endforeach
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-blue-500">{{$seasonKey}} Total Bosta: {{ $seasonBostaTotal }}</p>
                            <p>{{$seasonKey}} Total Amount: &#2547;{{ $seasonAmountTotal }}</p>
                            <p>{{$seasonKey}} Total Payment: &#2547;{{ $seasonPaymentTotal }}</p>
                            <p>{{$seasonKey}} Total Due: &#2547;{{ $seasonAmountTotal - $seasonPaymentTotal }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6">
            <p class="text-2xl font-extrabold text-blue-500 mt-2">Total Bosta: {{ $customer->bags->sum('bag_amount') }}</p>
            <p>Total Amount: &#2547;{{ $customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }) }}</p>
            <p class="mt-2 text-blue-500">Total Payment Amount: &#2547;{{ $customer->payments->sum('amount') }}</p>
            <p class="mt-2 text-blue-500">Total Due: &#2547;{{ $customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }) - $customer->payments->sum('amount') }}</p>
        </div>
    </div>
</div>


<script>
    const seasonLinks = document.querySelectorAll('.season-link');
    seasonLinks.forEach((link) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const seasonDetails = e.target.nextElementSibling;

            if (seasonDetails) {
                seasonDetails.classList.toggle('hidden');
            }
        });
    });


    document.getElementById('addNewBagButton').addEventListener('click', function () {
        var form = document.getElementById('form1');
        form.classList.toggle('hidden');
    });

    document.getElementById('addNewPaymentButton').addEventListener('click', function () {
        var form = document.getElementById('paymentForm');
        form.classList.toggle('hidden');
    });

    document.getElementById('bag_size').addEventListener('change', function () {
        var selectedSize = this.value;
        var perBagPriceInput = document.getElementById('per_bag_price');

        // Set the corresponding price based on the selected bag size
        if (selectedSize === 'feed') {
            perBagPriceInput.value = '30'; // Set the price for small size
        } else if (selectedSize === 'gom') {
            perBagPriceInput.value = '40'; // Set the price for medium size
        } else if (selectedSize === 'vushi') {
            perBagPriceInput.value = '45'; // Set the price for large size
        } else if (selectedSize === 'gom l') {
            perBagPriceInput.value = '50';
        } else {
            perBagPriceInput.value = ''; // Clear the price if no size is selected
        }
    });
</script>
@endsection
