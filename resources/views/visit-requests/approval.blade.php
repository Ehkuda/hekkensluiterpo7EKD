<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bezoekverzoek Behandelen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Request details -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h3 class="text-lg font-semibold mb-4">Verzoekdetails</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Bezoeker</h4>
                                <p class="text-gray-900">{{ $visitRequest->visitor_name }}</p>
                                <p class="text-gray-600 text-sm">{{ $visitRequest->visitor_email }}</p>
                                <p class="text-gray-600 text-sm">ID: {{ $visitRequest->visitor_id_document }}</p>
                                @if($visitRequest->visitor_phone)
                                    <p class="text-gray-600 text-sm">Tel: {{ $visitRequest->visitor_phone }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Gedetineerde</h4>
                                <p class="text-gray-900">
                                    {{ $visitRequest->detainee->naam_gedetineerd }} 
                                    {{ $visitRequest->detainee->achternaam_gedetineerd }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    Cel: {{ $visitRequest->detainee->locatie_vleugel_cel }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-700 mb-2">Gewenste bezoektijd</h4>
                            <p class="text-gray-900">
                                {{ $visitRequest->requested_visit_time->format('l, d F Y \o\m H:i') }}
                            </p>
                        </div>
                        
                        @if($visitRequest->reason_for_visit)
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Reden voor bezoek</h4>
                                <p class="text-gray-900">{{ $visitRequest->reason_for_visit }}</p>
                            </div>
                        @endif
                        
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-700 mb-2">Ingediend op</h4>
                            <p class="text-gray-900">{{ $visitRequest->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex space-x-4">
                        <!-- Approve form -->
                        <div class="flex-1">
                            <form method="POST" action="{{ route('visit-requests.approve', $visitRequest) }}" 
                                  class="bg-green-50 p-6 rounded-lg border border-green-200">
                                @csrf
                                @method('PUT')
                                
                                <h3 class="text-lg font-semibold text-green-800 mb-4">Verzoek Goedkeuren</h3>
                                
                                <div class="mb-4">
                                    <label for="actual_visit_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Definitieve bezoektijd *
                                    </label>
                                    <input type="datetime-local" 
                                           name="actual_visit_time" 
                                           id="actual_visit_time" 
                                           value="{{ $visitRequest->requested_visit_time->format('Y-m-d\TH:i') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                                           required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="approve_staff_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Opmerkingen (optioneel)
                                    </label>
                                    <textarea name="staff_notes" 
                                              id="approve_staff_notes" 
                                              rows="3" 
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                                              placeholder="Eventuele opmerkingen of instructies..."></textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                                        onclick="return confirm('Weet u zeker dat u dit verzoek wilt goedkeuren?')">
                                    Goedkeuren
                                </button>
                            </form>
                        </div>
                        
                        <!-- Reject form -->
                        <div class="flex-1">
                            <form method="POST" action="{{ route('visit-requests.reject', $visitRequest) }}" 
                                  class="bg-red-50 p-6 rounded-lg border border-red-200">
                                @csrf
                                @method('PUT')
                                
                                <h3 class="text-lg font-semibold text-red-800 mb-4">Verzoek Afwijzen</h3>
                                
                                <div class="mb-4">
                                    <label for="reject_staff_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Reden voor afwijzing *
                                    </label>
                                    <textarea name="staff_notes" 
                                              id="reject_staff_notes" 
                                              rows="4" 
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                                              placeholder="Geef een duidelijke reden voor de afwijzing..."
                                              required></textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                                        onclick="return confirm('Weet u zeker dat u dit verzoek wilt afwijzen?')">
                                    Afwijzen
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Back button -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('visit-requests.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            ← Terug naar overzicht
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>