<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats overzicht -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Gedetineerden stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Gedetineerden</h2>
                                <p class="text-3xl font-bold">{{ $totaalGedetineerden }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Totale cellen stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Totaal Cellen</h2>
                                <p class="text-3xl font-bold">{{ $totaalCellen }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bezetting stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Bezetting</h2>
                                <p class="text-3xl font-bold">{{ $bezetCellen }} / {{ $totaalCellen }}</p>
                                <p class="text-sm text-gray-500">{{ $beschikbareCellen }} cellen beschikbaar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recente gedetineerden -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-[#735C49]">Recente Gedetineerden</h2>
                        <a href="{{ route('gedetineerden.index') }}" class="px-4 py-2 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] transition-colors duration-300 text-sm">Alle Gedetineerden</a>
                    </div>
                    
                    @if($recenteGedetineerden->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Er zijn momenteel geen gedetineerden in het systeem.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-[#F7EADF] text-[#735C49]">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Naam</th>
                                        <th class="px-4 py-2 text-left">Cel</th>
                                        <th class="px-4 py-2 text-left">Datum Opsluiting</th>
                                        <th class="px-4 py-2 text-left">Datum Vrijlating</th>
                                        <th class="px-4 py-2 text-left">Delict</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#735C49]/10">
                                    @foreach($recenteGedetineerden as $gedetineerde)
                                        <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                            <td class="px-4 py-2 font-medium">{{ $gedetineerde->naam_gedetineerd }} {{ $gedetineerde->achternaam_gedetineerd }}</td>
                                            <td class="px-4 py-2">
                                                @if($gedetineerde->cel)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $gedetineerde->cel->naam }}
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Geen cel
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">{{ $gedetineerde->datum_opsluiting ?? 'Onbekend' }}</td>
                                            <td class="px-4 py-2">{{ $gedetineerde->datum_vrijlating ?? 'Onbekend' }}</td>
                                            <td class="px-4 py-2">{{ $gedetineerde->reden_gedetineerd }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Aankomende vrijlatingen -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-[#735C49]">Aankomende Vrijlatingen (7 dagen)</h2>
                    </div>
                    
                    @if($aankomendVrijlatingen->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Er zijn geen vrijlatingen gepland in de komende 7 dagen.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-[#F7EADF] text-[#735C49]">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Naam</th>
                                        <th class="px-4 py-2 text-left">Cel</th>
                                        <th class="px-4 py-2 text-left">Datum Vrijlating</th>
                                        <th class="px-4 py-2 text-left">Delict</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#735C49]/10">
                                    @foreach($aankomendVrijlatingen as $gedetineerde)
                                        <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                            <td class="px-4 py-2 font-medium">{{ $gedetineerde->naam_gedetineerd }} {{ $gedetineerde->achternaam_gedetineerd }}</td>
                                            <td class="px-4 py-2">
                                                @if($gedetineerde->cel)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $gedetineerde->cel->naam }}
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Geen cel
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">{{ $gedetineerde->datum_vrijlating }}</td>
                                            <td class="px-4 py-2">{{ $gedetineerde->reden_gedetineerd }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-[#735C49] mb-4">Snelle Acties</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('gedetineerden.create') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Nieuwe Gedetineerde</p>
                                </div>
                            </a>
                            <a href="{{ route('cellen.index') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Beheer Cellen</p>
                                </div>
                            </a>
                            <a href="{{ route('gedetineerden.index') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Overzicht Gedetineerden</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-[#735C49] mb-4">Cellen Status</h2>
                        <div class="flex flex-col space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Bezette Cellen</span>
                                <span class="font-semibold">{{ $bezetCellen }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-[#735C49] h-2.5 rounded-full" style="width: {{ $totaalCellen > 0 ? ($bezetCellen / $totaalCellen) * 100 : 0 }}%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Beschikbare Cellen</span>
                                <span class="font-semibold">{{ $beschikbareCellen }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $totaalCellen > 0 ? ($beschikbareCellen / $totaalCellen) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>