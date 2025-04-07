<?php

namespace App\Http\Controllers;

use App\Models\Gedetineerde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GedetineerdeController extends Controller
{
    public function index()
    {
        $gedetineerden = Gedetineerde::all();
        return view('overzicht-gedetineerde', compact('gedetineerden'));
    }


    public function wijzigen($id)
    {
        $gedetineerde = Gedetineerde::find($id);
        // Logica voor wijzigen
        return view('wijzigen', compact('gedetineerde'));
    }

    public function verwijderen($id)
    {
        $gedetineerde = Gedetineerde::find($id);
        $gedetineerde->delete();
        return redirect()->route('gedetineerden')->with('success', 'Gedetineerde verwijderd!');
    }

    public function overplaatsen(Request $request, $id)
    {
    $gedetineerde = Gedetineerde::findOrFail($id);

    if ($request->isMethod('post')) {
        $nieuw = $request->input('naar_locatie');
        $toen = $request->input('toen_locatie');

        $historie = empty($toen) ? $nieuw : $toen . ', ' . $nieuw;

        $gedetineerde->locatie_vleugel_cel = $nieuw;
        $gedetineerde->historie_locatie = $historie;
        $gedetineerde->save();

        return redirect()->route('gedetineerden')->with('success', 'Gedetineerde is overgeplaatst!');
    }

    return view('overplaatsen', compact('gedetineerde'));
}

public function update(Request $request, $id)
{
    $gedetineerde = Gedetineerde::findOrFail($id);

    $gedetineerde->update([
        'naam_gedetineerd' => $request->input('naam_gedetineerd'),
        'geboortedatum_gedetineerd' => $request->input('geboortedatum_gedetineerd'),
        'id_nummer' => $request->input('id_nummer'),
        'adres_gedetineerd' => $request->input('adres'),
        'bezittingen' => $request->input('bezittingen'),
        'datum_opsluiting' => $request->input('opsluitingsdatum'),
        'datum_vrijlating' => $request->input('vrijlatingsdatum'),
        'locatie_vleugel_cel' => $request->input('locatie'),
        'reden_gedetineerd' => $request->input('reden_gedetineerd'),
        'opmerkingen' => $request->input('opmerkingen'),
    ]);

    return redirect()->route('gedetineerden')->with('success', 'Gegevens succesvol bijgewerkt!');
}


}
