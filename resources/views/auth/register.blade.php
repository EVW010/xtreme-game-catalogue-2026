<x-guest-layout>

    <!-- Titel -->
    <h1 class="mb-6 text-center text-3xl font-bold text-gray-900">
        Registreren
    </h1>

    <!-- Registratieformulier -->
    <form method="POST" action="{{ route('register') }}">

        @csrf

        <!-- Naam -->
        <div>
            <x-input-label
                for="name"
                value="Naam"
            />

            <x-text-input
                id="name"
                class="mt-1 block w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>

        <!-- E-mailadres -->
        <div class="mt-4">

            <x-input-label
                for="email"
                value="E-mailadres"
            />

            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>

        <!-- Wachtwoord -->
        <div class="mt-4">

            <x-input-label
                for="password"
                value="Wachtwoord"
            />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>

        <!-- Wachtwoord bevestigen -->
        <div class="mt-4">

            <x-input-label
                for="password_confirmation"
                value="Bevestig wachtwoord"
            />

            <x-text-input
                id="password_confirmation"
                class="mt-1 block w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />

        </div>

        <!-- Registreren knop -->
        <button
            type="submit"
            class="mt-6 w-full rounded-md
                   bg-blue-600 px-5 py-3
                   font-medium text-white
                   hover:bg-blue-700"
        >
            Registreren
        </button>

    </form>

    <!-- Link naar inloggen -->
    <div class="mt-6 border-t border-gray-200 pt-5 text-center">

        <p class="mb-3 text-sm text-gray-600">
            Heb je al een account?
        </p>

        <a
            href="{{ route('login') }}"
            class="inline-flex w-full items-center justify-center
                   rounded-md border border-blue-600
                   px-5 py-3 font-medium text-blue-600
                   hover:bg-blue-50"
        >
            Inloggen
        </a>

    </div>

</x-guest-layout>
