<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>@yield('title', 'HRM Project')</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Rice Mill</a>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="text-gray-800 hover:text-gray-600 transition duration-300">Login</a>
            </div>
        </div>
    </nav>

    <div class="flex-grow container mx-auto py-8">
        @yield('content')
    </div>

    <footer class="bg-white text-center p-4">
        &copy; {{ date('Y') }} isDev. All rights reserved.
    </footer>
</body>
</html>
