<x-layout>

    <h1 class="text-3xl font-bold mb-4">
        Game Catalogue
    </h1>


    @guest

        <p>
            Je bent niet ingelogd.
        </p>

        <p>
            Log in om je eigen gamecollectie te beheren.
        </p>

    @endguest


    @auth

        <p>
            Welkom {{ Auth::user()->name }}!
        </p>

        <div class="mt-4 p-4 bg-gray-100">

            <h2 class="font-bold">
                Alleen voor ingelogde gebruikers
            </h2>

            <p>
                Hier kun je later jouw persoonlijke gamecollectie tonen.
            </p>

        </div>

    @endauth


    <h2 class="text-2xl font-bold mt-8 mb-4">
        Games
    </h2>

    @foreach($games as $game)

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

    @endforeach

</x-layout>
