<x-layout>
    <div class="mx-auto max-w-5xl">
        <h1 class="mb-6 text-3xl font-bold">Mijn collectie</h1>

        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4 text-2xl font-bold">Mijn games</h2>

        @forelse($myGames as $game)
            <div class="mb-4 rounded-lg border border-gray-200 bg-white p-5">
                <h3 class="text-xl font-bold">{{ $game->title }}</h3>
                <p class="mb-3">Genre: {{ $game->genre->name }}</p>

                <!-- Status aanpassen -->
                <form method="POST" action="{{ route('collection.update-status', $game) }}"
                      class="flex flex-wrap items-center gap-3">
                    @csrf
                    @method('PATCH')

                    <label for="status-{{ $game->id }}" class="font-medium">Status:</label>

                    <select id="status-{{ $game->id }}" name="status"
                            class="h-11 min-w-44 rounded-md border border-gray-300 bg-white px-3 text-gray-900">
                        <option value="wishlist" @selected($game->pivot->status === 'wishlist')>
                            Wil spelen
                        </option>
                        <option value="playing" @selected($game->pivot->status === 'playing')>
                            Bezig
                        </option>
                        <option value="completed" @selected($game->pivot->status === 'completed')>
                            Uitgespeeld
                        </option>
                    </select>

                    <button type="submit" class="h-11 rounded-md bg-blue-600 px-4 text-white hover:bg-blue-700">
                        Opslaan
                    </button>
                </form>

                @error('status')
                <p class="mt-2 text-red-600">{{ $message }}</p>
                @enderror

                <!-- Verwijderen uit collectie -->
                <form method="POST" action="{{ route('collection.destroy', $game) }}" class="mt-4">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                        Verwijderen uit collectie
                    </button>
                </form>
            </div>
        @empty
            <p class="mb-6 text-gray-600">
                Je hebt nog geen games in je collectie.
            </p>
        @endforelse

        <h2 class="mb-4 mt-8 text-2xl font-bold">Games toevoegen</h2>

        @forelse($availableGames as $game)
            <div
                class="mb-4 flex flex-wrap items-center justify-between gap-4 rounded-lg border border-gray-200 bg-white p-5">
                <div>
                    <h3 class="text-xl font-bold">{{ $game->title }}</h3>
                    <p>Genre: {{ $game->genre->name }}</p>
                </div>

                <form method="POST" action="{{ route('collection.store', $game) }}">
                    @csrf

                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        Toevoegen aan collectie
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-600">
                Er zijn geen andere actieve games om toe te voegen.
            </p>
        @endforelse
    </div>
</x-layout>
