<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rice Mill</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Styles -->

    </head>
    <body class="antialiased">
        <div class="flex items-center justify-center h-screen">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Please Login First</h1>
                <a href="{{route('login')}}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Login</a >
            </div>
        </div>
    </body>
</html>
