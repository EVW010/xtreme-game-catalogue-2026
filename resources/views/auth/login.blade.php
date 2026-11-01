<x-guest-layout>

    <!-- Titel -->
    <h1 class="mb-6 text-center text-3xl font-bold">
        Inloggen
    </h1>

    <!-- Session status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <!-- Loginformulier -->
    <form method="POST" action="{{ route('login') }}">

        @csrf

        <!-- E-mailadres -->
        <div>
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
                autofocus
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
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>

        <!-- Onthoud mij -->
        <div class="mt-4">

            <label class="inline-flex items-center">

                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 text-blue-600"
                >

                <span class="ml-2 text-sm text-gray-600">
                    Onthoud mij
                </span>

            </label>

        </div>

        <!-- Wachtwoord vergeten -->
        @if(Route::has('password.request'))

            <div class="mt-4 text-right">

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Wachtwoord vergeten?
                </a>

            </div>

        @endif

        <!-- Inloggen -->
        <button
            type="submit"
            class="mt-6 w-full rounded-md bg-blue-600
                   px-5 py-3 font-medium text-white
                   hover:bg-blue-700"
        >
            Inloggen
        </button>

    </form>

    <!-- Registreren -->
    <div class="mt-6 border-t border-gray-200 pt-5 text-center">

        <p class="mb-3 text-sm text-gray-600">
            Heb je nog geen account?
        </p>

        <a
            href="{{ route('register') }}"
            class="inline-flex w-full items-center justify-center
                   rounded-md border border-blue-600
                   px-5 py-3 font-medium text-blue-600
                   hover:bg-blue-50"
        >
            Registreren
        </a>

    </div>

</x-guest-layout>
