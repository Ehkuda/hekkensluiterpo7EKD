<?php

namespace App\Http\Controllers;

use App\Models\VisitRequest;
use App\Models\Gedetineerde;
use App\Models\Visitor;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitRequestController extends Controller
{
    /**
     * Toon publieke pagina voor het indienen van bezoekverzoeken
     */
    public function create()
    {
        $gedetineerden = Gedetineerde::orderBy('naam_gedetineerd')->get();
        return view('visit-requests.create', compact('gedetineerden'));
    }

    /**
     * Sla een nieuw bezoekverzoek op
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_id_document' => 'required|string|max:20',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'nullable|string|max:20',
            'detainee_id' => 'required|exists:gedetineerden,id',
            'requested_visit_time' => 'required|date|after:now',
            'reason_for_visit' => 'nullable|string|max:1000',
        ]);

        VisitRequest::create($validated);

        return redirect()->route('visit-requests.create')
                         ->with('success', 'Uw bezoekverzoek is ingediend en wordt beoordeeld door onze medewerkers.');
    }

    /**
     * Toon alle bezoekverzoeken voor staff (bewakers/coördinatoren)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = VisitRequest::with(['detainee', 'reviewedBy', 'visit']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $requests = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('visit-requests.index', compact('requests', 'status'));
    }

    /**
     * Toon details van een bezoekverzoek
     */
    public function show(VisitRequest $visitRequest)
    {
        $visitRequest->load(['detainee', 'reviewedBy', 'visit']);
        return view('visit-requests.show', compact('visitRequest'));
    }

    /**
     * Keur een bezoekverzoek goed
     */
    public function approve(Request $request, VisitRequest $visitRequest)
    {
        $validated = $request->validate([
            'staff_notes' => 'nullable|string|max:1000',
            'actual_visit_time' => 'required|date|after:now',
        ]);

        // Controleer of bezoeker al bestaat, anders maak nieuwe aan
        $visitor = Visitor::firstOrCreate(
            ['id_document_number' => $visitRequest->visitor_id_document],
            ['name' => $visitRequest->visitor_name]
        );

        // Maak het bezoek aan
        $visit = Visit::create([
            'visitor_id' => $visitor->id,
            'detainee_id' => $visitRequest->detainee_id,
            'arrival_time' => $validated['actual_visit_time'],
        ]);

        // Update het verzoek
        $visitRequest->update([
            'status' => VisitRequest::STATUS_APPROVED,
            'staff_notes' => $validated['staff_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'visit_id' => $visit->id,
        ]);

        return redirect()->route('visit-requests.index')
                         ->with('success', 'Bezoekverzoek goedgekeurd en bezoek ingepland.');
    }

    /**
     * Wijs een bezoekverzoek af
     */
    public function reject(Request $request, VisitRequest $visitRequest)
    {
        $validated = $request->validate([
            'staff_notes' => 'required|string|max:1000',
        ]);

        $visitRequest->update([
            'status' => VisitRequest::STATUS_REJECTED,
            'staff_notes' => $validated['staff_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('visit-requests.index')
                         ->with('success', 'Bezoekverzoek afgewezen.');
    }

    /**
     * Toon het goedkeuringsformulier
     */
    public function showApprovalForm(VisitRequest $visitRequest)
    {
        if (!$visitRequest->isPending()) {
            return redirect()->route('visit-requests.show', $visitRequest)
                           ->with('error', 'Dit verzoek is al behandeld.');
        }

        return view('visit-requests.approval', compact('visitRequest'));
    }
}