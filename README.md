# Xtreme Game Catalogue

## Over mijn project

Voor het vak Web Application Frameworks heb ik Xtreme Game Catalogue gemaakt met Laravel.

Ik heb gekozen voor een game library omdat ik zelf games leuk vind. Het leek mij leuk om een website te maken waar gebruikers games kunnen bekijken en hun eigen collectie kunnen bijhouden.

## Wat kan je doen?

Op mijn website kunnen bezoekers games bekijken, zoeken en filteren op genre en platform.

Als je een account hebt en bent ingelogd, kan je ook:

- Zelf games toevoegen.
- Je eigen games aanpassen of verwijderen.
- Games toevoegen aan je persoonlijke collectie.
- Aangeven of je een game wilt spelen, aan het spelen bent of hebt uitgespeeld.
- Reviews plaatsen als je minimaal 3 games hebt uitgespeeld.
- Je eigen profiel aanpassen.

## Admin

Ik heb ook een admin rol toegevoegd.

Als admin kom je na het inloggen op het admin dashboard. Daar kan je alle games bekijken en games activeren of deactiveren.

Normale gebruikers kunnen niet op het admin dashboard komen.

## Wat heb ik gebruikt?

Voor mijn project heb ik de volgende dingen gebruikt:

- Laravel en PHP voor de werking van de website.
- Blade voor de pagina's.
- Tailwind CSS voor de opmaak.
- Laravel Breeze voor het inloggen en registreren.
- Eloquent om met de database te werken.
- SQLite als database.

## Beveiliging

Ik heb ervoor gezorgd dat niet iedereen zomaar alles kan aanpassen.

Een gebruiker mag alleen zijn eigen toegevoegde games bewerken of verwijderen. Ook worden de gegevens gecontroleerd wanneer iemand een game toevoegt of aanpast.

Als iets niet goed is ingevuld, krijgt de gebruiker een foutmelding.

## Reviews

Voor het plaatsen van reviews heb ik een extra voorwaarde gemaakt.

Een gebruiker moet minimaal 3 games hebben uitgespeeld voordat hij een review mag plaatsen.

In mijn ReviewController controleer ik met Eloquent hoeveel games de gebruiker heeft uitgespeeld.

Als dat minder dan 3 is, kan de gebruiker nog geen review plaatsen.

## Project opstarten

Voor het opstarten heb je PHP, Composer, Node.js en SQLite nodig.

Open de projectmap in een terminal en voer de volgende stappen uit:

1. Installeer de Laravel-bestanden met `composer install`.
2. Installeer de frontend-bestanden met `npm install`.
3. Maak een `.env`-bestand aan met `copy .env.example .env` (op Windows).
4. Genereer een sleutel met `php artisan key:generate`.
5. Zet `DB_CONNECTION=sqlite` in het `.env`-bestand en maak indien nodig een leeg bestand `database/database.sqlite` aan.
6. Maak de database klaar met `php artisan migrate --seed`.
7. Start de frontend met `npm run dev`.
8. Start Laravel in een tweede terminal met `php artisan serve`.

De website is daarna te openen via `http://localhost:8000`.

## GitHub

Ik heb GitHub gebruikt om mijn voortgang bij te houden. Tijdens het maken van mijn project heb ik meerdere commits gemaakt waarin ik mijn wijzigingen heb opgeslagen.