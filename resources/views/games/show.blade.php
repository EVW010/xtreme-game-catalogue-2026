<x-layout>
    <div class="mx-auto max-w-5xl">

        <a href="{{ route('games.index') }}" class="mb-6 inline-block text-blue-600 hover:underline">
            Terug naar games
        </a>

        <!-- Gamegegevens -->
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-6">
            <h1 class="mb-4 text-3xl font-bold">{{ $game->title }}</h1>

            <p class="mb-2"><strong>Beschrijving:</strong> {{ $game->description }}</p>
            <p class="mb-2"><strong>Developer:</strong> {{ $game->developer }}</p>
            <p class="mb-2"><strong>Genre:</strong> {{ $game->genre->name }}</p>
            <p class="mb-2"><strong>Release date:</strong> {{ $game->release_date->format('d-m-Y') }}</p>

            <p class="font-bold">Platforms:</p>
            <ul class="ml-6 list-disc">
                @foreach($game->platforms as $platform)
                    <li>{{ $platform->name }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Reviews -->
        <h2 class="mb-4 text-2xl font-bold">Reviews</h2>

        @forelse($reviews as $review)
            <div class="mb-4 rounded-lg border border-gray-200 bg-white p-5">
                <p class="font-bold">{{ $review->user->name }}</p>
                <p class="mb-2 text-yellow-600">Beoordeling: {{ $review->rating }}/5</p>
                <p>{{ $review->content }}</p>
            </div>
        @empty
            <p class="mb-6 text-gray-600">Deze game heeft nog geen reviews.</p>
        @endforelse

        @if(session('success'))
            <div class="mb-4 rounded bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @error('review')
        <p class="mb-4 text-red-600">{{ $message }}</p>
        @enderror

        <!-- Review plaatsen -->
        @auth
            @if(!$game->is_active)
                <p class="mt-6 text-gray-600">
                    Deze game is inactief. Je kunt geen review plaatsen.
                </p>

            @elseif($alreadyReviewed)
                <p class="mt-6 text-gray-600">
                    Je hebt deze game al beoordeeld.
                </p>

            @elseif($completedGames < 3)
                <div class="mt-6 rounded-lg bg-gray-100 p-5">
                    <p class="font-bold">Review plaatsen</p>
                    <p class="mt-2">
                        Je hebt {{ $completedGames }} van de 3 benodigde games uitgespeeld.
                    </p>
                    <p class="mt-2">
                        Speel eerst minimaal 3 games uit om een review te plaatsen.
                    </p>
                    <a href="{{ route('collection.index') }}" class="mt-3 inline-block text-blue-600 hover:underline">
                        Ga naar Mijn collectie
                    </a>
                </div>

            @else
                <div class="mt-6 rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="mb-4 text-xl font-bold">Review plaatsen</h2>

                    <form method="POST" action="{{ route('reviews.store', $game) }}">
                        @csrf

                        <label for="rating" class="mb-2 block font-bold">
                            Beoordeling
                        </label>
                        <select id="rating" name="rating" required
                                class="mb-2 w-full rounded-md border border-gray-300 bg-white p-3">
                            <option value="">Kies een cijfer</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" @selected(old('rating') == $i)>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>

                        @error('rating')
                        <p class="mb-3 text-red-600">{{ $message }}</p>
                        @enderror

                        <label for="content" class="mb-2 mt-4 block font-bold">
                            Jouw review
                        </label>
                        <textarea id="content" name="content" rows="4"
                                  maxlength="1000" required
                                  class="w-full rounded-md border border-gray-300 p-3"
                                  placeholder="Wat vind je van deze game?">{{ old('content') }}</textarea>

                        @error('content')
                        <p class="mb-3 text-red-600">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                                class="mt-4 rounded-md bg-blue-600 px-5 py-3 text-white hover:bg-blue-700">
                            Review plaatsen
                        </button>
                    </form>
                </div>
            @endif

        @else
            <p class="mt-6">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                om een review te plaatsen.
            </p>
        @endauth

    </div>
</x-layout>
