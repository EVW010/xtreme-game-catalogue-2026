<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Game Catalogue</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<x-navigation/>

<main class="max-w-7xl mx-auto p-6">
    {{ $slot }}
</main>

</body>
</html>
