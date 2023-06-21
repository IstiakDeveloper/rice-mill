@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Customers</h3>
              <div class="flex flex-col sm:flex-row items-center mt-4 sm:mt-0">
                <p class="text-sm text-gray-500 mr-2 sm:mr-4">Total Amount Due: ৳{{ $totalAmount }}</p>
                <p class="text-sm text-gray-500">Total Collection: ৳{{ $totalPayment }}</p>
              </div>
              <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 sm:mt-0">Add New Customer</a>
            </div>
          </div>

        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('customers.index') }}">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <div class="mb-4 md:mb-0">
                      <input type="text" class="form-input rounded-md shadow-sm" name="area" placeholder="Filter by Address" value="{{ request('Gram') }}">
                    </div>
                    <div class="mb-4 md:mb-0">
                      <input type="text" class="form-input rounded-md shadow-sm" name="name" placeholder="Filter by Name" value="{{ request('name') }}">
                    </div>
                    <div>
                      <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                        Filter
                      </button>
                    </div>
                  </div>

            </form>


            <div class="overflow-x-auto">
                <table class="min-w-full mt-4">
                  <thead>
                    <tr>
                      <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">SL</th>
                      <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                      <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Gram</th>
                      <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Mobile Number</th>
                      <th class="px-6 py-3 bg-gray-50 text-xs text-center leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                      <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">
                          <div class="text-sm leading-5 font-medium text-gray-900">{{ $loop->iteration }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">
                          <div class="text-sm leading-5 font-medium text-gray-900">{{ $customer->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">{{ $customer->area }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">{{ $customer->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                          <a href="{{ route('customers.show', $customer->id) }}" class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Show</a>
                          <a href="{{ route('customers.edit', $customer->id) }}" class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline ml-2">Edit</a>
                          <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" class="text-red-600 hover:text-red-900 focus:outline-none focus:underline ml-2">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>


            <div class="mt-4">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
