@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
        <div class="text-center">
            <img src="{{ $customer->image }}" alt="Profile Picture" class="rounded-full h-24 w-24 mx-auto mb-4" onerror="this.onerror=null; this.src='{{ asset('user.png') }}';">

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

                <div class="mt-4">
                        <a href="#" class="season-link text-xl font-semibold bg-gray-300 block rounded-lg py-2 px-8 mb-4 shadow-md hover:bg-gray-100">
                        <span class="season-icon"></span> Season: {{ $seasonKey }}
                    </a>

                    <div class="season-details hidden bg-gray-300">
                        <span class=" text-sm font-semibold mt-4 text-white bg-blue-500 shadow py-1 px-4">Entry for {{ $seasonKey }}</span>
                        <div class="relative overflow-x-auto border shadow-sm mb-4 mt-2">
                            <table class="w-full text-sm text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-md">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Serial
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Bosta
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Bosta Size
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Per Bosta Price
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Sub Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->bags->where('season.name', $seasonKey) as $bosta)
                                        <tr class="bg-white border-b ">
                                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-center">
                                                {{$bosta->bag_amount }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $bosta->bag_size }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                &#2547; {{ $bosta->per_bag_price }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $bosta->date }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                $subTotal = $bosta->bag_amount * $bosta->per_bag_price;
                                                @endphp
                                                &#2547; {{ $subTotal }}
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>


                        <span class=" text-sm font-semibold mt-4 text-white bg-blue-500 shadow py-1 px-4">Payments for {{ $seasonKey }}</span>

                        <div class="relative overflow-x-auto border shadow-sm mt-2">
                            <table class="w-full text-sm text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-md">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Serial
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->payments->where('season.name', $seasonKey) as $payment)
                                        <tr class="bg-white border-b ">
                                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-center">
                                                &#2547; {{ $payment->amount }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $payment->date }}
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-8">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                                <div>
                                    <p class="text-lg font-semibold">{{$seasonKey}} Total Bosta:</p>
                                    <p class="text-gray-800 text-lg font-bold">{{$seasonBostaTotal}}</p>
                                </div>
                                <div class="mt-4 md:mt-0">
                                    <p class="text-lg font-semibold">Total Amount:</p>
                                    <p class="text-gray-800 text-lg font-bold">&#2547;{{ number_format($seasonAmountTotal, 2) }}</p>
                                </div>
                                <div class="mt-4 md:mt-0">
                                    <p class="text-lg font-semibold">Total Payment:</p>
                                    <p class="text-green-500 text-lg font-bold">&#2547;{{ number_format($seasonPaymentTotal, 2) }}</p>
                                </div>
                                <div class="mt-4 md:mt-0">
                                    <p class="text-lg font-semibold">Total Due:</p>
                                    <p class="text-red-500 text-lg font-bold">&#2547;{{ number_format($seasonAmountTotal - $seasonPaymentTotal, 2) }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6 bg-gray-100 rounded-lg shadow-md">
            <p class="text-2xl font-bold text-blue-500 mb-4">Total Bosta: {{ $customer->bags->sum('bag_amount') }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-lg font-semibold">Total Amount:</p>
                    <p class="text-gray-800">&#2547;{{ number_format($customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }), 2) }}</p>
                </div>
                <div>
                    <p class="text-lg font-semibold">Total Payment Amount:</p>
                    <p class="text-green-500">&#2547;{{ number_format($customer->payments->sum('amount'), 2) }}</p>
                </div>
            </div>
            <hr class="my-4 border-t border-gray-300">
            <p class="text-lg font-semibold">Total Due:</p>
            <p class="text-red-500">&#2547;{{ number_format($customer->bags->sum(function($bag) { return $bag->bag_amount * $bag->per_bag_price; }) - $customer->payments->sum('amount'), 2) }}</p>
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


</script>
@endsection
