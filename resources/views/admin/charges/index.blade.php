@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-x-auto sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-semibold text-gray-800">Charges</h2>
                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-800">Total Amount: {{ $totalAmount }}</p>
                </div>
                <a href="{{ route('charges.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                    <i class="fas fa-plus"></i> Add Charge
                </a>
            </div>



            <div class="overflow-x-auto sm:align-middle min-w-full mt-4">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($charges as $charge)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $charge->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $charge->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $charge->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('charges.show', $charge) }}" class="text-blue-500 hover:underline mr-3">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('charges.edit', $charge) }}" class="text-indigo-500 hover:underline mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('charges.destroy', $charge) }}" method="POST" class="inline">
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
