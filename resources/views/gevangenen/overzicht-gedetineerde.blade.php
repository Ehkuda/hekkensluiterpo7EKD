@extends('layouts.app') <!-- Dit is je algemene layout bestand. Pas dit aan als je een ander layout bestand hebt. -->

@section('content')
    <div class="container">
        <div class="worker_menu">
            <div class="terug_blok">
                <a class="terug_knop" href="{{ route('klantenportaal') }}">
                    Terug naar klantenportaal
                </a>
            </div>
            <!-- Tijdelijke 2e menu voor het personeel -->
            <div class="menu_location">
                @include('inc.menu') <!-- Zorg ervoor dat je deze menu view hebt -->
            </div>
            <!-- uitloggen -->
            <div class="uitlog_blok">
                <a href="{{ route('logout') }}">Uitloggen</a>
            </div>
        </div>

        <div class="worker_content">
            <table>
                <thead>
                    <tr>
                        @switch($userRole)
                            @case('Bewaker')
                                <th>Gedetineerde</th>
                                <th>Cel & Vleugel</th>
                                @break
                            @default
                                <th>Gedetineerde</th>
                                <th>Geboortedatum</th>
                                <th>ID-nummer</th>
                                <th>Adres</th>
                                <th>Bezittingen</th>
                                <th>Opsluiting</th>
                                <th>Vrijlating</th>
                                <th>Volgend Bezoek</th>
                                <th>Bezoekers</th>
                                <th>Cel & Vleugel</th>
                                <th>Historie Cellen</th>
                                <th>Reden Gedetineerd</th>
                                <th>Extra Opmerking</th>
                                <th>Actie</th>
                                @break
                        @endswitch
                    </tr>
                </thead>
                <tbody>
                    @foreach($gedetineerden as $gedetineerde)
                        <tr>
                            @switch($userRole)
                                @case('Bewaker')
                                    <td>{{ $gedetineerde->naam_gedetineerd }}</td>
                                    <td>{{ $gedetineerde->locatie_vleugel_cel }}</td>
                                    @break
                                @default
                                    <td>{{ $gedetineerde->naam_gedetineerd }}</td>
                                    <td>{{ $gedetineerde->geboortedatum_gedetineerd }}</td>
                                    <td>{{ $gedetineerde->id_nummer }}</td>
                                    <td>{{ $gedetineerde->adres_gedetineerd }}</td>
                                    <td>{{ $gedetineerde->bezittingen }}</td>
                                    <td>{{ $gedetineerde->datum_opsluiting }}</td>
                                    <td>{{ $gedetineerde->datum_vrijlating }}</td>
                                    <td>{{ $gedetineerde->datum_tijd_bezoek }}</td>
                                    <td>{{ $gedetineerde->aantal_bezoeken }}</td>
                                    <td>{{ $gedetineerde->locatie_vleugel_cel }} 
                                        <a href="{{ route('overplaatsen', $gedetineerde->id) }}" class="btn-edit">
                                            <i class="material-icons md-24">edit</i>
                                        </a>
                                    </td>
                                    <td>{{ $gedetineerde->historie_locatie }}</td>
                                    <td>{{ $gedetineerde->reden_gedetineerd }}</td>
                                    <td>{{ $gedetineerde->opmerkingen }}</td>
                                    <td>
                                        <a href="{{ route('wijzigen', $gedetineerde->id) }}" class="btn-edit">
                                            <i class="material-icons md-24">edit</i>
                                        </a>
                                        <a href="{{ route('verwijderen', $gedetineerde->id) }}" class="btn-delete">
                                            <i class="material-icons md-10">delete</i>
                                        </a>
                                    </td>
                                    @break
                            @endswitch
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
