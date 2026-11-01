<nav class="bg-gray-800 p-4 text-white">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4">

        <a href="{{ route('games.index') }}" class="font-bold hover:text-gray-300">
            Game Catalogue
        </a>

        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('games.index') }}" class="hover:underline">
                Games
            </a>

            @auth
                <a href="{{ route('collection.index') }}" class="hover:underline">
                    Mijn collectie
                </a>

                <a href="{{ route('profile.edit') }}" class="hover:underline">
                    Profiel
                </a>

                @if(auth()->user()->role === 1)
                    <a href="{{ route('admin.dashboard') }}" class="hover:underline">
                        Admin
                    </a>
                @endif

                <span class="border-l border-gray-600 pl-4 font-medium text-blue-300">
                    Hallo, {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cursor-pointer hover:underline">
                        Uitloggen
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">
                    Inloggen
                </a>

                <a href="{{ route('register') }}" class="hover:underline">
                    Registreren
                </a>
            @endauth
        </div>
    </div>
</nav>
