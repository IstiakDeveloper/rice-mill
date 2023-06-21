@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Create Customer</h3>
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
            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="image"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('image')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" autocomplete="name" required
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <label for="area" class="block text-sm font-medium text-gray-700">Address</label>

                        <select name="area" id="area" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                    <div class="col-span-6 sm:col-span-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="text" name="phone_number" id="phone_number" pattern="[0-9]*"
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                      </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('customers.index') }}"
                        class="mr-4 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-200 transition duration-150 ease-in-out">Cancel</a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
