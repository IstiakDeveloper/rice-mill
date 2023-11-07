@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white shadow-md rounded-md p-8 w-full sm:w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Balance</h2>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-600 text-sm font-semibold mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full form-input" required>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-600 text-sm font-semibold mb-2">Date</label>
                    <input type="date" name="date" id="date" class="w-full form-input"
                        value="{{ now()->toDateString() }}" required>
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-gray-600 text-sm font-semibold mb-2">Amount</label>
                    <input type="text" name="amount" id="amount" class="w-full form-input" required>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 rounded-md">
                        <i class="fas fa-check"></i> Save Balance
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
