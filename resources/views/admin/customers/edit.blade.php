@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Customer</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if ($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <label for="image" class="block font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" class="form-input mt-1 block w-full">
                </div>

                <div>
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ $customer->name }}" class="form-input mt-1 block w-full">
                  </div>

                  <div class="mt-4">
                    <label for="area" class="block font-medium text-gray-700">Area</label>
                    <input type="text" name="area" id="area" value="{{ $customer->area }}" class="form-input mt-1 block w-full">
                  </div>

                  <div class="mt-4">
                    <label for="phone_number" class="block font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ $customer->phone_number }}" class="form-input mt-1 block w-full">
                  </div>
                <div class="mt-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">Update</button>
                    <a href="{{ route('customers.index') }}"
                        class="inline-flex items-center ml-2 px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:shadow-outline-gray active:bg-gray-300 transition duration-150 ease-in-out">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
