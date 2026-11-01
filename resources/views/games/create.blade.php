<x-layout>
    <h1 class="mb-6 text-3xl font-bold">Game toevoegen</h1>

    <form method="POST" action="{{ route('games.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="title">Titel</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full border p-2">

            @error('title')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description">Beschrijving</label>
            <textarea id="description" name="description" class="w-full border p-2">{{ old('description') }}</textarea>

            @error('description')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="developer">Developer</label>
            <input type="text" id="developer" name="developer" value="{{ old('developer') }}" class="w-full border p-2">

            @error('developer')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="release_date">Releasedatum</label>
            <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}"
                   class="w-full border p-2">

            @error('release_date')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="genre_id">Genre</label>
            <select id="genre_id" name="genre_id" class="w-full border p-2">
                <option value="">Kies een genre</option>

                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" @selected(old('genre_id') == $genre->id)>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>

            @error('genre_id')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <p class="mb-2 font-bold">Platforms</p>

            @foreach($platforms as $platform)
                <label class="mb-1 block">
                    <input type="checkbox" name="platforms[]" value="{{ $platform->id }}"
                        @checked(in_array($platform->id, old('platforms', [])))>
                    {{ $platform->name }}
                </label>
            @endforeach

            @error('platforms')
            <p class="text-red-500">{{ $message }}</p>
            @enderror

            @error('platforms.*')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 px-4 py-2 text-white">
            Game toevoegen
        </button>
    </form>
</x-layout>
