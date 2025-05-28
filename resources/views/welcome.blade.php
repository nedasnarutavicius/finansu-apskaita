<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finansų Apskaitos Sistema</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=advent-pro:400" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col justify-center items-center min-h-screen font-sans">
    <header class="mb-8 text-center">
        <h1 class="text-3xl font-bold mb-2">Asmeninių finansų apskaitos sistema</h1>
        <p class="text-gray-600">Tvarkyk pajamas, išlaidas ir matyk savo balansą vienoje vietoje</p>
    </header>

    <nav class="flex gap-4">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Pagrindinis</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Prisijungti</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Registruotis</a>
                @endif
            @endauth
        @endif
    </nav>
</body>
</html>
