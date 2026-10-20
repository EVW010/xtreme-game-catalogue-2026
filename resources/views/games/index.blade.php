<x-layout>

    <h1 class="text-3xl font-bold mb-6">
        Game Catalogue
    </h1>

    @auth
        <a
            href="{{ route('games.create') }}"
            class="inline-block bg-blue-600 text-white px-4 py-2 mb-6"
        >
            Game toevoegen
        </a>
    @endauth

    @if(session('success'))
        <div class="bg-green-100 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @foreach($games as $game)

        <div class="border p-4 mb-4">

            <h2 class="text-xl font-bold">
                {{ $game->title }}
            </h2>

            <p>
                Developer: {{ $game->developer }}
            </p>

            <p>
                Genre: {{ $game->genre->name }}
            </p>

            <p>
                Release date:
                {{ $game->release_date->format('d-m-Y') }}
            </p>

            <p>
                Platforms:
            </p>

            <ul>
                @foreach($game->platforms as $platform)
                    <li>{{ $platform->name }}</li>
                @endforeach
            </ul>

            @auth
                @if(auth()->id() === $game->user_id || auth()->user()->role === 1)

                    <div class="flex gap-2 mt-4">

                        <a
                            href="{{ route('games.edit', $game) }}"
                            class="inline-block bg-yellow-500 px-4 py-2"
                        >
                            Bewerken
                        </a>

                        <form
                            method="POST"
                            action="{{ route('games.destroy', $game) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="bg-red-600 text-white px-4 py-2"
                                onclick="return confirm('Weet je zeker dat je deze game wilt verwijderen?')"
                            >
                                Verwijderen
                            </button>
                        </form>

                    </div>

                @endif
            @endauth

        </div>

    @endforeach

</x-layout>
