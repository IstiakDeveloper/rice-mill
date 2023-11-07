@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-800">Edit AutoCharge</h1>
    </div>
    <div class="p-6">
        <form action="{{ route('charges.update', $charge->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-600 text-sm font-semibold">Name</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ $charge->name }}">
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-600 text-sm font-semibold">Date</label>
                <input type="date" name="date" id="date" class="form-input" value="{{ $charge->date }}">
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-gray-600 text-sm font-semibold">Amount</label>
                <input type="number" name="amount" id="amount" class="form-input" value="{{ $charge->amount }}">
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Charge</button>
            </div>
        </form>
    </div>
</div>
@endsection
