@extends('layouts.app')
@section('content')

    <div class="">
        <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
    </div>
    <div class=" flex mb-8 bg-white shadow overflow-hidden sm:rounded-lg p-6 justify-between items-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg" onclick="openModal()">Add Entry</button>
        <button onclick="openPaymentModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Add Payment</button>
    </div>

        <!-- Responsive Buttons -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <div class="flex flex-wrap justify-between mt-4">
            <!-- Add Expense Button -->
            <a href="{{ route('expenses.create') }}"
            class="w-full sm:w-auto px-4 py-2 bg-red-500 text-center text-white rounded-md hover:bg-red-700 mb-4">
                <i class="fas fa-plus"></i> Add Expense
            </a>

            <!-- Add Charge Button -->
            <a href="{{ route('charges.create') }}"
            class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-center    text-white rounded-md hover:bg-blue-700 mb-4">
                <i class="fas fa-plus"></i> Auto Charge
            </a>

            <!-- Add Balance Button -->
            <a href="{{ route('accounts.create') }}"
            class="w-full sm:w-auto px-4 py-2 bg-green-500 text-center   text-white rounded-md hover:bg-green-700 mb-4">
                <i class="fas fa-plus"></i> Add Balance
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            <!-- Accounts -->
            <div class="bg-blue-200 p-4 rounded-md">
                <div class="bg-blue-200 mb-4 rounded-md flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-blue-800">Accounts</h3>
                    <p class="text-lg font-semibold text-blue-800">
                        Total: ৳{{ $accountTotal }}
                    </p>
                </div>

                <ul>
                    @foreach ($accounts->sortByDesc('created_at')->take(5) as $account)
                        <li class="text-sm text-blue-700">{{ $account->name }}: ৳{{ $account->amount }}</li>
                    @endforeach
                </ul>

            </div>

            <!-- Expenses -->
            <div class="bg-red-200 p-4 rounded-md">
                <div class="bg-red-200 mb-4 rounded-md flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-red-800">Expenses</h3>
                    <p class="text-lg font-semibold text-red-800">
                        Total: ৳{{ $expensesTotal }}
                    </p>
                </div>

                <ul>
                    @foreach ($expenses->sortByDesc('created_at')->take(5) as $expense)
                        <li class="text-sm text-red-700">{{ $expense->reason }}: ৳{{ $expense->amount }}</li>
                    @endforeach
                </ul>

            </div>

            <!-- Total Balance Chart -->
            <div class="bg-green-200 p-4 rounded-md">
                <div class="bg-green-200 mb-4 rounded-md flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-green-800">Total Balance</h3>
                    <p class="text-lg font-semibold text-green-800">
                        Total: ৳{{ $balance }}
                    </p>
                </div>

                <ul>
                    <li class="text-sm text-green-700">Accounts: ৳{{ $accountTotal }}</li>
                    <li class="text-sm text-green-700">Expenses: ৳{{ $expensesTotal  }}</li>
                </ul>

            </div>
        </div>
    </div>

    <div id="entryModal" class="fixed inset-0 overflow-auto flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/2">
            <h2 class="text-xl font-bold mb-4">Add Entry</h2>
            <form id="entryForm" method="POST" action="{{ route('entries.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        oninput="checkCustomer(this.value)" required>
                    <input type="hidden" id="customer_id" name="customer_id">
                    <div id="customer_list" class="mt-2 hidden h-24 overflow-auto">
                        <!-- Suggestions will be appended here -->
                    </div>
                </div>
                <div id="customer_fields" class="hidden">
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <label for="area" class="block text-sm font-medium text-gray-700">Address</label>
                        <select name="area" id="area" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" >Select Para</option>
                            <option value="DorgaPara" {{ old('area') === 'DorgaPara' ? 'selected' : '' }}>DorgaPara</option>
                            <option value="SorokPara" {{ old('area') === 'SorokPara' ? 'selected' : '' }}>SorokPara</option>
                            <option value="MadrashaPara" {{ old('area') === 'MadrashaPara' ? 'selected' : '' }}>MadrashaPara</option>
                            <option value="BombuPara" {{ old('area') === 'BombuPara' ? 'selected' : '' }}>BombuPara</option>
                            <option value="MondolPara" {{ old('area') === 'MondolPara' ? 'selected' : '' }}>MondolPara</option>
                            <option value="UttorPara" {{ old('area') === 'UttorPara' ? 'selected' : '' }}>UttorPara</option>
                            <option value="PukurPara" {{ old('area') === 'PukurPara' ? 'selected' : '' }}>PukurPara</option>
                            <option value="FaraziPara" {{ old('area') === 'FaraziPara' ? 'selected' : '' }}>FaraziPara</option>
                            <option value="Nodirkul" {{ old('area') === 'Nodirkul' ? 'selected' : '' }}>Nodirkul</option>
                        </select>
                        @error('area')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="image" name="image"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="bag_amount" class="block text-sm font-medium text-gray-700">Koto Bosta</label>
                    <input type="text" id="bag_amount" name="bag_amount" value="{{ old('bag_amount') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                <div class="mb-4">
                    <label for="bag_size" class="block text-sm font-medium text-gray-700">Bosta Size</label>
                    <select id="bag_size" name="bag_size"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                        <option value="">Select Bosta Size</option>
                        <option value="feed">feed</option>
                        <option value="gom">gom</option>
                        <option value="vushi">vushi</option>
                        <option value="gom l">gom l</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="per_bag_price" class="block text-sm font-medium text-gray-700">Per Bosta Price</label>
                    <input type="number" id="per_bag_price" name="per_bag_price" value="{{ old('per_bag_price') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>

    </div>








<!-- Add Payment Modal -->
<!-- Payment Modal -->


<div id="paymentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h2 class="text-xl font-bold mb-4">Add Payment</h2>

        <form id="paymentForm" method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="mb-4">
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                <select id="customer_id2" name="customer_id2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required onchange="updateRemainingBalance(this.value)">
                    <option value="">Select Customer</option>
                    <option>Search Customer...</option>
                    <!-- Other customer options will be populated dynamically -->
                </select>
            </div>




            <!-- Display Customer Total Amount -->
            <div class="mb-4">
                <span id="customer_total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></span>
            </div>

            <div class="mb-4">
                <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                <input type="number" id="payment_amount" name="payment_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div class="mb-4">
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="closePaymentModal()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>






@endsection


