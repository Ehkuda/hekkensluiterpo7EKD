<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/style.css')
    <title>Wijzigen</title>
</head>
<body>
    {{-- Navigatie --}}
    @include('partials.menu-klantenportaal')

    <div class="worker_menu">
        <div class="terug_blok">
            <a class="terug_knop" href="{{ route('gedetineerden') }}">Terug naar klantenportaal</a>
        </div>

        <div class="menu_location">
            @include('partials.menu')
        </div>

        <div class="uitlog_blok">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Uitloggen</button>
            </form>
        </div>
    </div>

    {{-- Wijzigingsformulier --}}
    <div class="worker_content_wijzigen">
        <form method="POST" action="{{ route('gedetineerde.update', $gedetineerde->id) }}">
            @csrf
            @method('PUT')

            <br><h2>{{ $gedetineerde->naam_gedetineerd }}</h2>
            <h1>Gegevens wijzigen</h1><br>

            <label for="naam_gedetineerd">Naam gedetineerde*:</label><br>
            <input type="text" name="naam_gedetineerd" value="{{ old('naam_gedetineerd', $gedetineerde->naam_gedetineerd) }}"><br><br>

            <label for="geboortedatum_gedetineerd">Geboortedatum*:</label><br>
            <input type="date" name="geboortedatum_gedetineerd" value="{{ old('geboortedatum_gedetineerd', $gedetineerde->geboortedatum_gedetineerd) }}"><br><br>

            <label for="id_nummer">ID-nummer*:</label><br>
            <input type="number" name="id_nummer" value="{{ old('id_nummer', $gedetineerde->id_nummer) }}"><br><br>

            <label for="adres">Adres*:</label><br>
            <input type="text" name="adres" value="{{ old('adres', $gedetineerde->adres_gedetineerd) }}"><br><br>

            <label for="bezittingen">Bezittingen:</label><br>
            <input type="text" name="bezittingen" value="{{ old('bezittingen', $gedetineerde->bezittingen) }}"><br><br>

            <label for="opsluitingsdatum">Opsluitingsdatum*:</label><br>
            <input type="date" name="opsluitingsdatum" value="{{ old('opsluitingsdatum', $gedetineerde->datum_opsluiting) }}"><br><br>

            <label for="vrijlatingsdatum">Vrijlatingsdatum*:</label><br>
            <input type="date" name="vrijlatingsdatum" value="{{ old('vrijlatingsdatum', $gedetineerde->datum_vrijlating) }}"><br><br>

            <label for="locatie">Locatie vleugel & cel*:</label><br>
            <input type="text" name="locatie" value="{{ old('locatie', $gedetineerde->locatie_vleugel_cel) }}"><br><br>

            <label for="reden_gedetineerd">Reden gedetineerd*:</label><br>
            <input type="text" name="reden_gedetineerd" value="{{ old('reden_gedetineerd', $gedetineerde->reden_gedetineerd) }}"><br><br>

            <label for="opmerkingen">Opmerkingen:</label><br>
            <textarea name="opmerkingen">{{ old('opmerkingen', $gedetineerde->opmerkingen) }}</textarea><br><br><br>

            <input type="submit" value="Opslaan"><br><br>
        </form>
    </div>
</body>
</html>
