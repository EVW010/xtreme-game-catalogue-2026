@props(['game'])

<div class="border p-4 mb-4">

    <h3 class="font-bold">
        {{ $game['title'] }}
    </h3>

    <p>
        Genre: {{ $game['genre'] }}
    </p>

    <p>
        Platform: {{ $game['platform'] }}
    </p>

</div>
