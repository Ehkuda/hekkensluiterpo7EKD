<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overplaatsen</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>

    @include('components.menu-klantenportaal')
    
    <div class="worker_menu">
        <div class="terug_blok">
            <a class="terug_knop" href="{{ route('dashboard') }}">Terug naar klantenportaal</a>
        </div>
        <div class="menu_location">
            @include('components.menu')
        </div>
        <div class="uitlog_blok">
            <a href="{{ route('logout') }}">Uitloggen</a>
        </div>
    </div>

    <div class="worker_content_overplaatsen">
        <form method="POST">
            @csrf
            <br><h1>Overplaatsen van<br>{{ $gedetineerde->naam_gedetineerd }}</h1><br>

            <label for="toen_locatie">Oudere locaties:</label><br>
            <input type="text" id="toen_locatie" name="toen_locatie" value="{{ $gedetineerde->historie_locatie }}"><br><br>

            <label for="naar_locatie">Nieuwe locatie:</label><br>
            <input type="text" id="naar_locatie" name="naar_locatie" placeholder="Bijv. A01, B14, C23" required><br><br><br>

            <input type="submit" value="Opslaan"><br><br>
        </form>
    </div>

</body>
</html>
