<x-layout>

    <div class="mx-auto max-w-5xl py-8">

        <!-- Titel -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900">
            Admin dashboard
        </h1>


        <!-- Uitleg -->
        <p class="mb-6 text-gray-700">
            Welkom op het admin dashboard.
            Dit gedeelte is alleen toegankelijk voor admins.
        </p>


        <div class="rounded-lg border border-gray-200
                    bg-white p-6 shadow-sm">

            <h2 class="mb-3 text-xl font-bold">
                Games beheren
            </h2>

            <p class="mb-5 text-gray-700">
                Als admin kun je games bekijken,
                activeren en deactiveren.
            </p>


            <!-- Naar gamecatalogus -->
            <a
                href="{{ route('games.index') }}"
                class="inline-flex items-center justify-center
                       rounded-md bg-blue-600 px-5 py-3
                       text-white hover:bg-blue-700"
            >
                Naar gamecatalogus
            </a>

        </div>

    </div>

</x-layout>
