@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-x-auto sm:rounded-lg">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Accounts</h2>
                <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                    <i class="fas fa-plus"></i> Add Balance
                </a>
            </div>
            <div class="my-4  bg-gray-100 p-4">
                <p class="text-lg font-semibold text-center text-gray-800">Account Total: {{ $accountTotal }}</p>
                <p class="text-lg font-semibold text-center text-gray-800">Expense Total: {{ $expensesTotal }}</p>
                <p class="text-lg font-semibold text-center text-gray-800">Balance Available: {{ $balance }}</p>
            </div>

            <div class="mt-4">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $account->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $account->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $account->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
