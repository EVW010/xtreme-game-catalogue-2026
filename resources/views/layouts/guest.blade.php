<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>Game Catalogue</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased">

<!-- Navigatie -->
<x-navigation/>

<!-- Inloggen en registreren -->
<main class="flex min-h-[80vh] items-center justify-center px-4 py-10">

    <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-md">

        {{ $slot }}

    </div>

</main>

</body>

</html>
