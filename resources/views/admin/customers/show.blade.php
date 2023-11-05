@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 text-center">
                <img src="{{ $customer->image }}" alt="Profile Picture" class="rounded-full h-24 w-24 mx-auto mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $customer->name }}</h3>
                <p class="mt-1 text-sm text-gray-500 text-center">{{ $customer->area }}</p>
                <div class="mt-4">
                    <a href="{{ route('bags.pdf', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Download PDF
                    </a>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <!-- Display customer information -->
                <div class="my-4">
                    <h4 class="text-lg font-medium">Bosta</h4>
                    @php
                        $subtotal = 0;
                    @endphp
                    @forelse ($customer->bags as $bag)
                    <div class="flex justify-between items-center mt-2 bg-gray-100 p-4 rounded-lg">
                        <div>
                            <p class="text-lg font-semibold">Bosta Details</p>
                            <div class="group-hover:text-red-600">
                                <p class="mt-2">Bosta: {{ $bag->bag_amount }}</p>
                                <p>Bosta Size: {{ $bag->bag_size }}</p>
                                <p>Per Bosta Price: &#2547;{{ $bag->per_bag_price }}</p>
                                <p>Date: {{ $bag->date }}</p>
                                @php
                                    $subTotal = $bag->bag_amount * $bag->per_bag_price;
                                    $subtotal += $subTotal;
                                @endphp
                                <p class="text-right mt-4">Sub-total: &#2547;{{ $subTotal }}</p>
                            </div>
                        </div>
                    </div>
                        <hr class="my-2">
                    @empty
                        <p>No bosta found.</p>
                    @endforelse
                </div>

                <div class="mt-5">
                    <h4 class="text-lg font-medium">Total: &#2547;{{ $subtotal - $customer->payments->sum('amount') }}</h4>
                </div>

                <!-- Add Bag Form -->

                <button id="addNewBagButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-5">
                    Add New Bosta
                </button>

                <form id="form1" method="POST" action="{{ route('bags.store', $customer) }}" class="hidden">
                    @csrf
                    <!-- Bag form fields here -->
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="bag_amount" class="block text-sm font-medium text-gray-700">Koto Bosta</label>
                            <input type="text" id="bag_amount" name="bag_amount" value="{{ old('bag_amount') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @error('bag_amount')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="bag_size" class="block text-sm font-medium text-gray-700">Bosta Size</label>
                            <select id="bag_size" name="bag_size" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
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
                            <input type="number" id="per_bag_price" name="per_bag_price" value="{{ old('per_bag_price') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @error('per_bag_price')
                              <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                          </div>
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @error('date')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mb-6 py-2 px-4 rounded">
                            Add Bosta
                        </button>
                    </div>
                </form>

                <!-- Add Payment Form -->
                <button id="addNewPaymentButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Payment
                  </button>
                  <form id="paymentForm" method="POST" action="{{ route('bags.pay', $customer) }}" class="hidden">
                    @csrf
                    <!-- Payment form fields here -->
                    <div class="mt-4">
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                        <input type="number" id="payment_amount" name="payment_amount" value="{{ old('payment_amount') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('payment_amount')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date') ?? date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('payment_date')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Pay
                        </button>
                    </div>
                </form>

                <!-- Display Payment Information -->
                <div class="mt-6">
                    <h4 class="text-lg font-medium">Payments</h4>
                    @forelse ($customer->payments as $payment)
                        <div class="flex justify-between items-center mt-2">
                            <div>
                                <p>Amount: &#2547;{{ $payment->amount }}</p>
                                <p>Date: {{ $payment->date }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                    @empty
                        <p>No payments found.</p>
                    @endforelse

                    @if($customer->payments->count() > 0)
                        <div class="mt-4">
                            <p class="font-medium">Total Payment: &#2547;{{ $customer->payments->sum('amount') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('addNewBagButton').addEventListener('click', function () {
          var form = document.getElementById('form1'); // Replace 'form1' with the actual id of the form you want to toggle
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
            }
             else {
            perBagPriceInput.value = ''; // Clear the price if no size is selected
            }
        });
      </script>

@endsection
