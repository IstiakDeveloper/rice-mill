@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Customers</h3>
              <form method="GET" action="{{ route('customers.index') }}" class="flex items-center space-x-4">
                <label for="season" class="text-sm font-medium text-gray-700">Select Season:</label>
                <select name="season" id="season" class="block w-32 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Seasons</option>
                    @foreach ($seasons as $s)
                        <option value="{{ $s->name }}" {{ $s->name == $selectedSeason ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Filter</button>
            </form>
            <div class="flex flex-col sm:flex-row items-center mt-4 sm:mt-0">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <p class="text-sm text-gray-500 mr-2 sm:mr-4">
                        Total Amount Due: ৳{{ $totalAmount - $totalPayment }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Total Collection: ৳{{ $totalPayment }}
                    </p>
                </div>
            </div>


              <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 sm:mt-0">Add New Customer</a>


          </div>

        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('customers.index') }}">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <div class="mb-4 md:mb-0">
                      <select class="form-select rounded-md shadow-sm" name="area" placeholder="Filter by Address">
                        <option value="">Select Para</option>
                        <option value="DorgaPara" {{ request('area') === 'DorgaPara' ? 'selected' : '' }}>DorgaPara</option>
                        <option value="SorokPara" {{ request('area') === 'SorokPara' ? 'selected' : '' }}>SorokPara</option>
                        <option value="MadrashaPara" {{ request('area') === 'MadrashaPara' ? 'selected' : '' }}>MadrashaPara</option>
                        <option value="BombuPara" {{ request('area') === 'BombuPara' ? 'selected' : '' }}>BombuPara</option>
                        <option value="MondolPara" {{ request('area') === 'MondolPara' ? 'selected' : '' }}>MondolPara</option>
                        <option value="UttorPara" {{ request('area') === 'UttorPara' ? 'selected' : '' }}>UttorPara</option>
                        <option value="PukurPara" {{ request('area') === 'PukurPara' ? 'selected' : '' }}>PukurPara</option>
                        <option value="FaraziPara" {{ request('area') === 'FaraziPara' ? 'selected' : '' }}>FaraziPara</option>
                        <option value="Nodirkul" {{ request('area') === 'Nodirkul' ? 'selected' : '' }}>Nodirkul</option>
                    </select>
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
                      <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Due Amount</th>
                      <th class="px-6 py-3 bg-gray-50 text-xs text-center leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                    @php
                        $index = ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration;
                    @endphp
                      <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">
                            <div class="text-sm leading-5 font-medium text-gray-900">{{ $index }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">
                          <div class="text-sm leading-5 font-medium text-gray-900"><a href="{{ route('customers.show', $customer->id) }}">{{ $customer->name }}</a></div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">{{ $customer->area }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center">{{ $customer->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 text-gray-500">
                            ৳{{ $customer->bags->sum('total') - $customer->payments->sum('amount')  }}
                        </td>
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
