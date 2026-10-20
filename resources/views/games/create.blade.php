<x-layout>

    <h1 class="text-3xl font-bold mb-6">
        Game toevoegen
    </h1>

    <form
        method="POST"
        action="{{ route('games.store') }}"
        class="space-y-4"
    >
        @csrf

        <div>
            <label for="title">
                Titel
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                class="border p-2 w-full"
            >

            @error('title')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <div>
            <label for="description">
                Beschrijving
            </label>

            <textarea
                id="description"
                name="description"
                class="border p-2 w-full"
            >{{ old('description') }}</textarea>

            @error('description')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <div>
            <label for="developer">
                Developer
            </label>

            <input
                type="text"
                id="developer"
                name="developer"
                value="{{ old('developer') }}"
                class="border p-2 w-full"
            >

            @error('developer')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <div>
            <label for="release_date">
                Releasedatum
            </label>

            <input
                type="date"
                id="release_date"
                name="release_date"
                value="{{ old('release_date') }}"
                class="border p-2 w-full"
            >

            @error('release_date')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        {{-- Genre --}}
        <div>
            <label for="genre_id">
                Genre
            </label>

            <select
                id="genre_id"
                name="genre_id"
                class="border p-2 w-full"
            >
                <option value="">
                    Kies een genre
                </option>

                @foreach($genres as $genre)
                    <option
                        value="{{ $genre->id }}"
                        @selected(old('genre_id') == $genre->id)
                    >
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>

            @error('genre_id')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        {{-- Platforms --}}
        <div>
            <p class="font-bold mb-2">
                Platforms
            </p>

            @foreach($platforms as $platform)

                <label class="block mb-1">

                    <input
                        type="checkbox"
                        name="platforms[]"
                        value="{{ $platform->id }}"
                        @checked(
                            in_array(
                                $platform->id,
                                old('platforms', [])
                            )
                        )
                    >

                    {{ $platform->name }}

                </label>

            @endforeach

            @error('platforms')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror

            @error('platforms.*')
            <p class="text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2"
        >
            Game toevoegen
        </button>

    </form>

</x-layout>
