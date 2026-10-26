<x-layout>

    <div class="mx-auto max-w-6xl">

        <!-- Titel -->
        <h1 class="mb-6 text-3xl font-bold">
            Game Catalogue
        </h1>


        <!-- Game toevoegen -->
        @auth

            <a
                href="{{ route('games.create') }}"
                class="mb-6 inline-flex items-center
                       rounded-md bg-blue-600 px-5 py-2
                       text-white hover:bg-blue-700"
            >
                Game toevoegen
            </a>

        @endauth


        <!-- Succesmelding -->
        @if(session('success'))

            <div class="mb-6 rounded-md
                        bg-green-100 p-4 text-green-800">

                {{ session('success') }}

            </div>

        @endif


        <!-- Zoeken en filteren -->
        <form
            method="GET"
            action="{{ route('games.index') }}"
            class="mb-8 flex flex-wrap items-center gap-3"
        >

            <!-- Zoekveld -->
            <input
                type="text"
                name="search"
                placeholder="Zoek op titel of developer"
                value="{{ request('search') }}"
                class="h-11 w-64 rounded-md
                       border border-gray-300
                       bg-white px-4 text-gray-900
                       focus:outline-none
                       focus:ring-2 focus:ring-blue-500"
            >


            <!-- Genre dropdown -->
            <div class="relative w-48">

                <select
                    name="genre_id"
                    class="h-11 w-full appearance-none
                           rounded-md border border-gray-300
                           bg-white pl-4 pr-10 text-gray-900
                           focus:outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

                    <option value="">
                        Alle genres
                    </option>


                    @foreach($genres as $genre)

                        <option
                            value="{{ $genre->id }}"
                            @selected(request('genre_id') == $genre->id)
                        >
                            {{ $genre->name }}
                        </option>

                    @endforeach

                </select>


                <!-- Pijltje -->
                <svg
                    class="pointer-events-none absolute
                           right-3 top-1/2 h-5 w-5
                           -translate-y-1/2 text-gray-600"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 9l-7 7-7-7"
                    />

                </svg>

            </div>


            <!-- Zoeken -->
            <button
                type="submit"
                class="inline-flex h-11 cursor-pointer
                       items-center justify-center
                       rounded-md bg-blue-600 px-5
                       text-white hover:bg-blue-700"
            >
                Zoeken
            </button>


            <!-- Wissen -->
            <a
                href="{{ route('games.index') }}"
                class="inline-flex h-11 items-center
                       justify-center rounded-md
                       bg-gray-200 px-5 text-gray-900
                       hover:bg-gray-300"
            >
                Wissen
            </a>

        </form>


        <!-- Games -->
        @forelse($games as $game)

            <div class="mb-5 rounded-lg
                        border border-gray-200
                        bg-white p-6 shadow-sm">

                <!-- Titel -->
                <h2 class="mb-3 text-2xl font-bold">
                    {{ $game->title }}
                </h2>


                <!-- Developer -->
                <p class="mb-1">
                    <strong>Developer:</strong>
                    {{ $game->developer }}
                </p>


                <!-- Genre -->
                <p class="mb-1">
                    <strong>Genre:</strong>
                    {{ $game->genre->name }}
                </p>


                <!-- Releasedatum -->
                <p class="mb-1">
                    <strong>Release date:</strong>
                    {{ $game->release_date->format('d-m-Y') }}
                </p>


                <!-- Platforms -->
                <p class="mt-3 font-bold">
                    Platforms:
                </p>

                <ul class="ml-6 mt-1 list-disc">

                    @foreach($game->platforms as $platform)

                        <li>
                            {{ $platform->name }}
                        </li>

                    @endforeach

                </ul>


                <!-- Alleen ingelogde gebruikers -->
                @auth

                    <!-- Admin of eigenaar ziet status -->
                    @if(auth()->user()->role === 1 ||
                        auth()->id() === $game->user_id)

                        <p class="mt-5 font-bold">
                            Status:

                            <span class="{{ $game->is_active
                                ? 'text-green-600'
                                : 'text-red-600' }}">

                                {{ $game->is_active
                                    ? 'Actief'
                                    : 'Inactief' }}

                            </span>

                        </p>

                    @endif


                    <!-- Alleen admin kan status wijzigen -->
                    @if(auth()->user()->role === 1)

                        <form
                            method="POST"
                            action="{{ route('games.toggle-active', $game) }}"
                            class="mt-3"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="inline-flex h-11 cursor-pointer
                                       items-center rounded-md px-5
                                       text-white
                                       {{ $game->is_active
                                           ? 'bg-gray-700 hover:bg-gray-800'
                                           : 'bg-green-600 hover:bg-green-700' }}"
                            >

                                {{ $game->is_active
                                    ? 'Deactiveren'
                                    : 'Activeren' }}

                            </button>

                        </form>

                    @endif


                    <!-- Alleen uploader mag bewerken en verwijderen -->
                    @if(auth()->id() === $game->user_id)

                        <div class="mt-5 flex flex-wrap
                                    items-center gap-3">

                            <!-- Bewerken -->
                            <a
                                href="{{ route('games.edit', $game) }}"
                                class="inline-flex h-11 items-center
                                       rounded-md bg-yellow-500
                                       px-5 text-black
                                       hover:bg-yellow-600"
                            >
                                Bewerken
                            </a>


                            <!-- Verwijderen -->
                            <form
                                method="POST"
                                action="{{ route('games.destroy', $game) }}"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex h-11
                                           cursor-pointer items-center
                                           rounded-md bg-red-600 px-5
                                           text-white hover:bg-red-700"
                                    onclick="return confirm('Weet je zeker dat je deze game wilt verwijderen?')"
                                >
                                    Verwijderen
                                </button>

                            </form>

                        </div>

                    @endif

                @endauth

            </div>

        @empty

            <!-- Geen games -->
            <div class="rounded-lg bg-gray-100 p-6">

                <p class="text-gray-600">
                    Geen games gevonden.
                </p>

            </div>

        @endforelse

    </div>

</x-layout>
