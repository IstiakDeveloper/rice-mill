@extends('layouts.app')
@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>

        <!-- Responsive Buttons -->
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

    <div class="flex justify-center mt-8">
        <div class="w-full">
            <div class="bg-white shadow-lg rounded-lg p-20">
                <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Welcome to admin home</h1>
                <p class="text-lg text-gray-600 mb-8 text-center">Create your customer and manage your business.</p>
                <div class="flex justify-center">
                    <a href="{{route('customers.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Get Started
                    </a>
                </div>
            </div>
        </div>
        </div>
@endsection


