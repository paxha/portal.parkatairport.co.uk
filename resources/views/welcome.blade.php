<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coming Soon</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-15906a2926639-dbd68b248383?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
        <div class="relative text-center text-white p-8">
            <h1 class="text-5xl md:text-7xl font-bold mb-4">Coming Soon</h1>
            <p class="text-lg md:text-2xl text-gray-300">We're working hard to bring you something amazing. Stay tuned!</p>
        </div>
    </div>
</body>
</html>
