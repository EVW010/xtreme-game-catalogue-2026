<x-layout>
    <div class="mx-auto max-w-6xl py-6">
        <h1 class="mb-4 text-3xl font-bold">Admin dashboard</h1>

        <p class="mb-6 text-gray-700">
            Hier kun je alle games bekijken, activeren en deactiveren.
        </p>

        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Games beheren</h2>
            <span class="text-gray-600">Totaal: {{ $games->count() }}</span>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">Game</th>
                    <th class="p-4">Developer</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Actie</th>
                </tr>
                </thead>

                <tbody>
                @forelse($games as $game)
                    <tr class="border-t border-gray-200">
                        <td class="p-4 font-medium">
                            <a href="{{ route('games.show', $game) }}" class="text-blue-600 hover:underline">
                                {{ $game->title }}
                            </a>
                        </td>

                        <td class="p-4">{{ $game->developer }}</td>

                        <td class="p-4">
                            @if($game->is_active)
                                <span class="font-medium text-green-600">Actief</span>
                            @else
                                <span class="font-medium text-red-600">Inactief</span>
                            @endif
                        </td>

                        <td class="p-4">
                            <form method="POST" action="{{ route('games.toggle-active', $game) }}">
                                @csrf

                                <button type="submit"
                                        class="rounded-md px-4 py-2 text-white {{ $game->is_active ? 'bg-gray-700 hover:bg-gray-800' : 'bg-green-600 hover:bg-green-700' }}">
                                    {{ $game->is_active ? 'Deactiveren' : 'Activeren' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-600">
                            Er zijn nog geen games toegevoegd.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('games.index') }}"
           class="mt-6 inline-block rounded-md bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
            Naar gamecatalogus
        </a>
    </div>
</x-layout>
