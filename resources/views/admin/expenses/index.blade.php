@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-x-auto sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Expenses</h2>
                <a href="{{ route('expenses.create') }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                    <i class="fas fa-plus"></i> Add Expense
                </a>
            </div>

            <table class="min-w-full mt-4">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reason
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('expenses.edit', $expense) }}" class="text-indigo-500 hover:underline mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Are you sure?')">
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
@endsection
