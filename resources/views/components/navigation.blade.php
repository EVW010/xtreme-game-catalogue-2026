<nav class="bg-gray-800 text-white p-4">
    <div class="max-w-7xl mx-auto flex justify-between">

        <div>
            <a href="{{ route('home') }}" class="font-bold">
                Game Catalogue
            </a>
        </div>

        <div class="flex gap-4">

            <a href="{{ route('home') }}">
                Home
            </a>

            @auth

                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('profile.edit') }}">
                    Profiel
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit">
                        Uitloggen
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}">
                    Inloggen
                </a>

                <a href="{{ route('register') }}">
                    Registreren
                </a>

            @endauth

        </div>

    </div>
</nav>
