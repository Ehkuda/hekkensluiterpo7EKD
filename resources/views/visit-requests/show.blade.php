<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bezoekverzoek Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Status badge -->
                    <div class="mb-6">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            {{ $visitRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $visitRequest->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $visitRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $visitRequest->getStatusDisplayName() }}
                        </span>
                    </div>

                    <!-- Request details -->
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <!-- Visitor info -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Bezoeker</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Naam:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->visitor_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">ID-nummer:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->visitor_id_document }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">E-mail:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->visitor_email }}</dd>
                                </div>
                                @if($visitRequest->visitor_phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Telefoon:</dt>
                                        <dd class="text-sm text-gray-900">{{ $visitRequest->visitor_phone }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Detainee info -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Gedetineerde</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Naam:</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $visitRequest->detainee->naam_gedetineerd }} 
                                        {{ $visitRequest->detainee->achternaam_gedetineerd }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Locatie:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->detainee->locatie_vleugel_cel }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">ID-nummer:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->detainee->id_nummer }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Visit details -->
                    <div class="bg-blue-50 p-6 rounded-lg mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Bezoekdetails</h3>
                        <dl class="grid md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Gewenste bezoektijd:</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ $visitRequest->requested_visit_time->format('l, d F Y \o\m H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Aangevraagd op:</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ $visitRequest->created_at->format('d-m-Y H:i') }}
                                </dd>
                            </div>
                        </dl>

                        @if($visitRequest->reason_for_visit)
                            <div class="mt-4">
                                <dt class="text-sm font-medium text-gray-600 mb-2">Reden voor bezoek:</dt>
                                <dd class="text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $visitRequest->reason_for_visit }}
                                </dd>
                            </div>
                        @endif
                    </div>

                    <!-- Review details (if reviewed) -->
                    @if($visitRequest->reviewed_at)
                        <div class="bg-gray-50 p-6 rounded-lg mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Behandeling</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Behandeld door:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->reviewedBy->name ?? 'Onbekend' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Behandeld op:</dt>
                                    <dd class="text-sm text-gray-900">{{ $visitRequest->reviewed_at->format('d-m-Y H:i') }}</dd>
                                </div>
                                @if($visitRequest->staff_notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600 mb-2">Opmerkingen:</dt>
                                        <dd class="text-sm text-gray-900 bg-white p-3 rounded border">
                                            {{ $visitRequest->staff_notes }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif

                    <!-- Linked visit (if approved) -->
                    @if($visitRequest->visit)
                        <div class="bg-green-50 p-6 rounded-lg mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Gekoppeld Bezoek</h3>
                            <dl class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Ingeplande tijd:</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $visitRequest->visit->arrival_time->format('d-m-Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Status:</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($visitRequest->visit->departure_time)
                                            <span class="text-green-600">Voltooid</span>
                                        @else
                                            <span class="text-blue-600">Ingepland</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                            
                            <div class="mt-4">
                                <a href="{{ route('visitors.show', $visitRequest->visit->visitor_id) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Bekijk bezoekdetails →
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <a href="{{ route('visit-requests.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            ← Terug naar overzicht
                        </a>

                        @if($visitRequest->isPending())
                            @can('visit-requests.approve')
                                <a href="{{ route('visit-requests.approval', $visitRequest) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    Behandelen
                                </a>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>