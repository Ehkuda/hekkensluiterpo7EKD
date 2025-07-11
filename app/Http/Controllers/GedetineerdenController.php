<?php

namespace App\Http\Controllers;

use App\Models\Gedetineerde;
use App\Models\Cel;
use Illuminate\Http\Request;

class GedetineerdenController extends Controller
{

    public function dashboard()
    {
        // Get total detainees
        $totaalGedetineerden = Gedetineerde::count();
        
        // Get recent detainees (last 5 added)
        $recenteGedetineerden = Gedetineerde::with('cel')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get total cells
        $totaalCellen = Cel::count();
        
        // Get available cells
        $beschikbareCellen = Cel::whereNull('gedetineerde_id')->count();
        
        // Get occupied cells
        $bezetCellen = Cel::whereNotNull('gedetineerde_id')->count();
        
        // Get upcoming releases (next 7 days)
        $aankomendVrijlatingen = Gedetineerde::whereNotNull('datum_vrijlating')
            ->whereDate('datum_vrijlating', '>=', now())
            ->whereDate('datum_vrijlating', '<=', now()->addDays(7))
            ->orderBy('datum_vrijlating', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totaalGedetineerden', 
            'recenteGedetineerden', 
            'totaalCellen', 
            'beschikbareCellen', 
            'bezetCellen', 
            'aankomendVrijlatingen'
        ));
    }

    // Index voor alle gedetineerden
    public function index(Request $request)
    {
        $zoekterm = $request->input('zoekterm');
        $gedetineerdenQuery = Gedetineerde::with('cel');
        $perPage = 15;

        if ($zoekterm) {
            $zoekterm = preg_replace('/[^a-z0-9]/', '', strtolower($zoekterm));
            $alleGedetineerden = $gedetineerdenQuery->get();

            $gefilterde = $alleGedetineerden->filter(function ($gedetineerde) use ($zoekterm) {
                $score = 0;

                if (strpos(strtolower($gedetineerde->naam_gedetineerd), $zoekterm) !== false) {
                    $score += 100;
                }
                if (strpos(strtolower($gedetineerde->achternaam_gedetineerd ?? ''), $zoekterm) !== false) {
                    $score += 100;
                }

                $celNaam = strtolower($gedetineerde->cel->naam ?? '');
                $vereenvoudigdeCel = preg_replace('/[^a-z0-9]/', '', $celNaam);

                if (strpos($vereenvoudigdeCel, $zoekterm) !== false) {
                    $score += 100;
                }

                return $score > 0;
            });

            $page = request()->get('page', 1);
            $offset = ($page - 1) * $perPage;
            $paged = $gefilterde->slice($offset, $perPage)->values();

            $gedetineerden = new \Illuminate\Pagination\LengthAwarePaginator(
                $paged,
                $gefilterde->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $gedetineerden = $gedetineerdenQuery->paginate($perPage);
        }

        // Controleer hier of er gedetineerden zijn, zo niet stuur een lege collectie
        $gedetineerden = $gedetineerden ?? collect(); // Zorg ervoor dat het geen null is

        return view('gedetineerden.index', compact('gedetineerden', 'zoekterm'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gedetineerde = Gedetineerde::with('cel')->findOrFail($id);
        
        // Optionally get the cell history for this detainee
        $celGeschiedenis = $gedetineerde->celGeschiedenis()->with('cel')->get();
        
        return view('gedetineerden.show', compact('gedetineerde', 'celGeschiedenis'));
    }

    // Toevoegen van een nieuwe gedetineerde
    public function create()
    {
        $beschikbareCellen = Cel::whereNull('gedetineerde_id')->get();
        $delicten = [
            (object)['naam' => 'Diefstal'],
            (object)['naam' => 'Fraude'],
            (object)['naam' => 'Geweld'],
        ];
        return view('gedetineerden.create', compact('beschikbareCellen', 'delicten'));
    }

    // Opslaan van een nieuwe gedetineerde
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam_gedetineerd' => 'required|string|max:255',
            'achternaam_gedetineerd' => 'required|string|max:255',
            'geboortedatum_gedetineerd' => 'required|date',
            'id_nummer' => 'required|string|max:20',
            'adres_gedetineerd' => 'required|string|max:255',
            'datum_opsluiting' => 'required|date',
            'datum_vrijlating' => 'nullable|date|after_or_equal:datum_opsluiting',
            'cel_id' => 'required|exists:cels,id',
            'reden_gedetineerd' => 'required|string',
            'opmerkingen' => 'nullable|string',
        ]);

        $gedetineerde = Gedetineerde::create([
            'naam_gedetineerd' => $validated['naam_gedetineerd'],
            'achternaam_gedetineerd' => $validated['achternaam_gedetineerd'],
            'geboortedatum_gedetineerd' => $validated['geboortedatum_gedetineerd'],
            'id_nummer' => $validated['id_nummer'],
            'adres_gedetineerd' => $validated['adres_gedetineerd'],
            'datum_opsluiting' => $validated['datum_opsluiting'],
            'datum_vrijlating' => $validated['datum_vrijlating'],
            'reden_gedetineerd' => $validated['reden_gedetineerd'],
            'opmerkingen' => $validated['opmerkingen'] ?? null,
            'locatie_vleugel_cel' => $validated['cel_id'],
        ]);

        $cel = Cel::find($validated['cel_id']);
        if ($cel) {
            $cel->gedetineerde_id = $gedetineerde->id;
            $cel->save();
        }

        return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde toegevoegd!');
    }

    // Bewerken van een gedetineerde
    public function edit($id)
    {
        $gedetineerde = Gedetineerde::findOrFail($id);
        $beschikbareCellen = Cel::all(); // Zodat je cel kan wijzigen indien nodig

        return view('gedetineerden.edit', compact('gedetineerde', 'beschikbareCellen'));
    }

    // Update van een gedetineerde
    public function update(Request $request, $id)
    {
        $gedetineerde = Gedetineerde::findOrFail($id);
        $huidigeOudeCel = Cel::where('gedetineerde_id', $gedetineerde->id)->first();
    
        $validated = $request->validate([
            'naam_gedetineerd' => 'required|string|max:255',
            'achternaam_gedetineerd' => 'required|string|max:255',
            'geboortedatum_gedetineerd' => 'required|date',
            'adres_gedetineerd' => 'required|string|max:255',
            'datum_opsluiting' => 'required|date',
            'datum_vrijlating' => 'nullable|date|after_or_equal:datum_opsluiting',
            'reden_gedetineerd' => 'required|string',
            'opmerkingen' => 'nullable|string',
            'cel_id' => 'nullable|exists:cels,id',  // Cel_id optioneel
        ]);
    
        $gedetineerde->update($validated);
    
        if ($request->filled('cel_id') && $huidigeOudeCel && $huidigeOudeCel->id != $request->cel_id) {
            // Registreer geschiedenis van de oude cel
            if ($huidigeOudeCel) {
                $huidigeOudeCel->celGeschiedenis()->create([
                    'gedetineerde_id' => $gedetineerde->id,
                    'cel_id' => $huidigeOudeCel->id,
                    'van_datum' => now()->subDay(), // Simuleer dat dit eerder was
                    'tot_datum' => now(),  // Nu verlaat de gedetineerde de cel
                ]);
                
                $huidigeOudeCel->gedetineerde_id = null;
                $huidigeOudeCel->save();
            }
    
            // Registreer geschiedenis van de nieuwe cel
            $nieuweCel = Cel::find($request->cel_id);
            if ($nieuweCel) {
                $nieuweCel->gedetineerde_id = $gedetineerde->id;
                $nieuweCel->save();
                
                // Voeg de nieuwe celgeschiedenis toe
                $nieuweCel->celGeschiedenis()->create([
                    'gedetineerde_id' => $gedetineerde->id,
                    'cel_id' => $nieuweCel->id,
                    'van_datum' => now(), // Nu gaat de gedetineerde naar de nieuwe cel
                    'tot_datum' => null,  // Nog niet vertrokken
                ]);
                
                $gedetineerde->locatie_vleugel_cel = $nieuweCel->id;
                $gedetineerde->save();
            } else {
                return redirect()->back()->with('error', 'De geselecteerde cel is niet beschikbaar.');
            }
        }
    
        return redirect()->route('gedetineerden.index')->with('success', 'Gegevens succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gedetineerde = Gedetineerde::findOrFail($id);
        
        // First, free up the cell if the detainee is in one
        if ($gedetineerde->locatie_vleugel_cel) {
            $cel = Cel::find($gedetineerde->locatie_vleugel_cel);
            if ($cel) {
                $cel->gedetineerde_id = null;
                $cel->save();
            }
        }
        
        // Close any open cell history records
        $gedetineerde->celGeschiedenis()
            ->whereNull('tot_datum')
            ->update(['tot_datum' => now()]);
        
        // Delete the detainee
        $gedetineerde->delete();
        
        return redirect()->route('gedetineerden.index')
            ->with('success', 'Gedetineerde succesvol verwijderd!');
    }

    public function geschiedenis(Gedetineerde $gedetineerde)
    {
        // Haal de celgeschiedenis op voor deze gedetineerde
        $geschiedenis = $gedetineerde->celGeschiedenis()->with('cel')->get();
        
        // Haal de cel van de gedetineerde, indien aanwezig
        $cel = $gedetineerde->cel;
        
        return view('cellen.geschiedenis', compact('gedetineerde', 'geschiedenis', 'cel'));
    }
    
    // Index van alle cellen
    public function cellenIndex(Request $request)
    {
        $zoekterm = $request->input('zoekterm');

        $query = Cel::with('gedetineerde');

        if ($zoekterm) {
            $query->where(function ($q) use ($zoekterm) {
                $q->where('naam', 'like', '%' . $zoekterm . '%')
                    ->orWhereHas('gedetineerde', function ($q) use ($zoekterm) {
                        $q->where('naam_gedetineerd', 'like', '%' . $zoekterm . '%');
                    });
            });
        }

        $cellen = $query->paginate(15);

        // Controleer of cellen null zijn, zo niet stuur een lege collectie
        $cellen = $cellen ?? collect(); // Zorg ervoor dat het geen null is

        return view('cellen.index', compact('cellen', 'zoekterm'));
    }

    // Formulier om een gedetineerde te verplaatsen
    public function showVerplaatsForm($celId)
    {
        $cel = Cel::findOrFail($celId);
        $beschikbareCellen = Cel::whereNull('gedetineerde_id')->get();
        return view('cellen.verplaats', compact('cel', 'beschikbareCellen'));
    }

    // Verplaats een gedetineerde naar een andere cel
    public function verplaatsGedetineerde(Request $request, $celId)
    {
        $validated = $request->validate([
            'cel_id' => 'required|exists:cels,id',
        ]);

        $cel = Cel::findOrFail($celId);
        $gedetineerde = $cel->gedetineerde;

        if ($gedetineerde) {
            $nieuweCel = Cel::findOrFail($validated['cel_id']);

            // Registreer de geschiedenis van de oude cel
            if ($cel->gedetineerde_id) {
                $cel->celGeschiedenis()
                ->where('gedetineerde_id', $gedetineerde->id)
                ->whereNull('tot_datum')
                ->update(['tot_datum' => now()]);  // Slaat timestamp op met datum én tijd
            }

            // Oude cel leegmaken
            $cel->gedetineerde_id = null;
            $cel->save();

            // Registreer de geschiedenis van de nieuwe cel
            if ($nieuweCel) {
                $nieuweCel->gedetineerde_id = $gedetineerde->id;
                $nieuweCel->save();

                // Voeg de nieuwe celgeschiedenis toe
                $nieuweCel->celGeschiedenis()->create([
                    'gedetineerde_id' => $gedetineerde->id,
                    'cel_id' => $nieuweCel->id,
                    'van_datum' => now(), // De huidige datum als 'van_datum'
                    'tot_datum' => null,  // Tot nu, omdat de gedetineerde nog niet verhuisd is
                ]);
            }

            // Update ook in de gedetineerde zelf
            $gedetineerde->locatie_vleugel_cel = $nieuweCel->id;
            $gedetineerde->save();

            return redirect()->route('cellen.index')->with('success', 'Gedetineerde succesvol verplaatst!');
        }

        return redirect()->route('cellen.index')->with('error', 'Er is geen gedetineerde om te verplaatsen.');
    }

    public function celGeschiedenis($celId)
    {
        $cel = Cel::findOrFail($celId);
        $geschiedenis = $cel->celGeschiedenis()->with('gedetineerde')->get();
        
        return view('cellen.geschiedenis', compact('cel', 'geschiedenis'));
    }
}