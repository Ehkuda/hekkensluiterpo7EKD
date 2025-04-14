<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <!-- Titel -->
                    <h1 class="text-3xl font-semibold text-[#735C49] mb-6 border-b border-[#735C49]/20 pb-2">
                        Celgeschiedenis
                    </h1>
                    
                    <!-- Cel informatie -->
                    <div class="mb-6 p-4 bg-[#F7EADF]/50 rounded-lg">
                        <h2 class="text-xl font-medium text-[#735C49]">Cel: {{ $cel->naam ?? 'Onbekend' }}</h2>
                    </div>
                    
                    <!-- Geschiedenis van de cel -->
                    @if($geschiedenis->isNotEmpty())
                        <div class="mt-4 bg-white shadow-md rounded-xl overflow-hidden border border-[#735C49]/20">
                            <table class="min-w-full divide-y divide-[#735C49]/10">
                                <thead class="bg-[#F7EADF]">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#735C49] uppercase tracking-wider">
                                            Gedetineerde
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#735C49] uppercase tracking-wider">
                                            Van datum
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#735C49] uppercase tracking-wider">
                                            Tot datum
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-[#735C49]/10">
                                    @foreach ($geschiedenis as $record)
                                    <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-[#735C49]">
                                                {{-- Controleer of gedetineerde bestaat --}}
                                                {{ $record->gedetineerde ? $record->gedetineerde->naam_gedetineerd : 'Onbekend' }}
                                                {{ $record->gedetineerde ? $record->gedetineerde->achternaam_gedetineerd ?? '' : '' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-[#735C49]/80">
                                                {{ \Carbon\Carbon::parse($record->van_datum)->format('d-m-Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-[#735C49]/80">
                                                @if($record->tot_datum)
                                                    {{ \Carbon\Carbon::parse($record->tot_datum)->format('d-m-Y') }}
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Heden
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-[#F7EADF]/30 p-6 rounded-lg text-[#735C49] text-center border border-[#735C49]/20">
                            <p class="text-lg">Geen geschiedenis beschikbaar voor deze cel</p>
                        </div>
                    @endif
                    
                    <!-- Terugknop naar overzicht van cellen -->
                    <div class="mt-8 flex">
                        <a href="{{ route('cellen.index') }}" class="inline-flex items-center px-5 py-2.5 bg-[#735C49] hover:bg-[#6a4e39] text-white font-medium rounded-md transition duration-150 ease-in-out shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Terug naar overzicht
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>