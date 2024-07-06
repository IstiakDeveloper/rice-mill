@extends('layouts.app')
@section('content')

    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
    </div>

    <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
        <input type="hidden" name="generate_report" value="1">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            Generate PDF Report
        </button>
    </form>

    <div class=" flex mb-8 bg-white shadow overflow-hidden sm:rounded-lg p-6 justify-between items-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg" onclick="openModal()">Add Entry</button>
        <button onclick="openPaymentModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Add Payment</button>
    </div>

    <div class="bg-white flex flex-wrap justify-between p-6 rounded-lg shadow-lg">
        <!-- Add Expense Button -->
        <a href="{{ route('expenses.create') }}"
        class="w-full sm:w-auto px-4 py-2 bg-red-500 text-center text-white rounded-md hover:bg-red-700 mb-4 md:mb-0">
            <i class="fas fa-plus"></i> Add Expense
        </a>

        <!-- Add Charge Button -->
        <a href="{{ route('charges.create') }}"
        class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-center    text-white rounded-md hover:bg-blue-700 mb-4 md:mb-0">
            <i class="fas fa-plus"></i> Auto Charge
        </a>

        <!-- Add Balance Button -->
        <a href="{{ route('accounts.create') }}"
        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-center   text-white rounded-md hover:bg-green-700 mb-4 md:mb-0">
            <i class="fas fa-plus"></i> Add Balance
        </a>
    </div>



    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-4">
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
            <div class="bg-blue-500 p-4 rounded-full text-white">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-700">&#2547;{{ $accountTotal }}</p>
                <p class="text-sm text-gray-500">Total Account</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
            <div class="bg-red-500 p-4 rounded-full text-white">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-700">&#2547;{{ $expensesTotal }}</p>
                <p class="text-sm text-gray-500">Total Expenses</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
            <div class="bg-green-500 p-4 rounded-full text-white">
                <i class="fas fa-balance-scale text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-700">&#2547;{{ $balance }}</p>
                <p class="text-sm text-gray-500">Balance</p>
            </div>
        </div>
    </div>


        <!-- Responsive Buttons -->
    <div class="bg-gray-50 shadow overflow-hidden sm:rounded-lg p-6 mb-4">
        <!-- Existing account and expense totals -->
        <h1 class="text-2xl my-2 font-semibold">Specific Date Data</h1>
        <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
            <div class="flex items-center space-x-4">
                <div>
                    <label for="date_option" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <select id="date_option" name="date_option" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="today" {{ $dateOption == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $dateOption == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="last_3_days" {{ $dateOption == 'last_3_days' ? 'selected' : '' }}>Last 3 Days</option>
                        <option value="last_7_days" {{ $dateOption == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="specific_date" {{ $dateOption == 'specific_date' ? 'selected' : '' }}>Specific Date</option>
                    </select>
                </div>
                <div>
                    <label for="specific_date" class="block text-sm font-medium text-gray-700">Specific Date</label>
                    <input type="date" id="specific_date" name="specific_date" value="{{ $specificDate }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-green-500 p-4 rounded-full text-white">
                    <i class="fas fa-suitcase text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $todayTotalBosta  }}</p>
                    <p class="text-sm text-gray-500">Total Bosta</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-blue-500 p-4 rounded-full text-white">
                    <i class="far fa-credit-card text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $todayTotalAmount  }}</p>
                    <p class="text-sm text-gray-500">Total Amount</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-red-500 p-4 rounded-full text-white">
                    <i class="fas fa-vote-yea text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $todayTotalAmount - $todayTotalPayment }}</p>
                    <p class="text-sm text-gray-500">Total Due</p>
                </div>
            </div>

        </div>
    </div>

    <div class="my-4 bg-gray-100 rounded-lg shadow-lg p-6">
        <h1 class="text-2xl my-2 font-semibold">Specific Season Data</h1>
        <label for="season">Select Season:</label>
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="selected_season" id="season">
                        <option value="">All Seasons</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}" {{ $selectedSeason == $season->id ? 'selected' : '' }}>{{ $season->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-green-500 p-4 rounded-full text-white">
                    <i class="fas fa-suitcase text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $bagsTotalAmount  }}</p>
                    <p class="text-sm text-gray-500">Total Bosta</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-blue-500 p-4 rounded-full text-white">
                    <i class="far fa-credit-card text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $totalPayments }}</p>
                    <p class="text-sm text-gray-500">Total Payments</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="bg-red-500 p-4 rounded-full text-white">
                    <i class="fas fa-vote-yea text-2xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-700">&#2547;{{ $totalDue }}</p>
                    <p class="text-sm text-gray-500">Total Due</p>
                </div>
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

            <div class="mb-4">
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                <input type="text" id="customer_search" name="customer_search" placeholder="Search Customer..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" oninput="searchCustomers(this.value)">
            </div>

            <div class="mt-2 h-24 overflow-auto hidden" id="search_results"></div>

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


