@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow-lg mt-20">
        <h2 class="text-2xl font-bold mb-6">Forgot Password</h2>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full py-2 px-3 border rounded placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring">{{ __('Email Password Reset Link') }}</button>
            </div>
        </form>
    </div>
@endsection
