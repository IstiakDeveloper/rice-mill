@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Charge Details</h2>

            <div class="mt-4">
                <p><span class="font-semibold">Name:</span> {{ $charge->name }}</p>
                <p><span class="font-semibold">Date:</span> {{ $charge->date }}</p>
                <p><span class="font-semibold">Amount:</span> {{ $charge->amount }}</p>
            </div>

            <a href="{{ route('charges.index') }}" class="mt-4 text-blue-500 hover:underline">
                <i class="fas fa-arrow-left"></i> Back to Charges
            </a>
        </div>
    </div>
@endsection
