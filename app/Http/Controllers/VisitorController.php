<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Visit;
use App\Models\Gedetineerde;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Toont een lijst van bezoekers met zoek- en paginering.
     */
    public function index(Request $request)
    {
        $zoekterm = $request->input('zoekterm');
        $visitorsQuery = Visitor::with('visits.detainee');

        if ($zoekterm) {
            $visitorsQuery->where('name', 'like', '%' . $zoekterm . '%')
                          ->orWhere('id_document_number', 'like', '%' . $zoekterm . '%');
        }

        $visitors = $visitorsQuery->paginate(15);

        return view('visitors.index', compact('visitors', 'zoekterm'));
    }

    /**
     * Formulier voor het aanmaken van een nieuwe bezoeker.
     */
    public function create()
    {
        $gedetineerden = Gedetineerde::all();
        return view('visitors.create', compact('gedetineerden'));
    }

    /**
     * Slaat een nieuwe bezoeker en bezoekmoment op.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_document_number' => 'required|string|max:20|unique:visitors',
            'detainee_id' => 'required|exists:gedetineerden,id',
            'arrival_time' => 'required|date',
        ]);

        $visitor = Visitor::create([
            'name' => $validated['name'],
            'id_document_number' => $validated['id_document_number'],
        ]);

        Visit::create([
            'visitor_id' => $visitor->id,
            'detainee_id' => $validated['detainee_id'],
            'arrival_time' => $validated['arrival_time'],
        ]);

        return redirect()->route('visitors.index')
                         ->with('success', 'Bezoeker en bezoekmoment succesvol geregistreerd!');
    }

    /**
     * Toont de details van een bezoeker, inclusief bezoeken.
     */
    public function show($id)
    {
        $visitor = Visitor::with('visits.detainee')->findOrFail($id);
        return view('visitors.show', compact('visitor'));
    }

    /**
     * Werk de vertrektijd van een bezoek bij.
     */
    public function updateDeparture(Request $request, $visitId)
    {
        $visit = Visit::findOrFail($visitId);

        $validated = $request->validate([
            'departure_time' => 'required|date|after:arrival_time',
        ]);

        $visit->update(['departure_time' => $validated['departure_time']]);

        return redirect()->route('visitors.show', $visit->visitor_id)
                         ->with('success', 'Vertrektijd succesvol geregistreerd!');
    }
}
