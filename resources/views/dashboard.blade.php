<x-app-layout>
    <x-slot name="header">
        <div class="min-h-screen flex justify-center">
            <div class="w-full">
              <div class="bg-white shadow-lg rounded-lg p-20">
                <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Welcome to admin home</h1>
                <p class="text-lg text-gray-600 mb-8 text-center">Create your customer and manage your business.</p>
                <div class="flex justify-center">
                  <a href="{{route('customers.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Get Started
                  </a>
                </div>
              </div>
            </div>
          </div>

    </x-slot>
</x-app-layout>
