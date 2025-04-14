<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <h1 class="text-3xl font-semibold text-[#735C49] mb-4 sm:mb-0">Overzicht van Cellen</h1>
                        
                        <!-- The "Nieuwe Cel" button has been removed as requested -->
                    </div>

                    <!-- Zoekbalk & Filters -->
                    <div class="mb-8 bg-[#F7EADF]/40 p-4 rounded-lg border border-[#735C49]/20">
                        <form method="GET" action="{{ route('cellen.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="w-full sm:w-1/2">
                                <label for="zoekterm" class="block text-sm font-medium text-[#735C49] mb-1">Zoekterm</label>
                                <input type="text" name="zoekterm" id="zoekterm" value="{{ $zoekterm }}" 
                                      class="px-4 py-2 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full" 
                                      placeholder="Zoek op cel/gedetineerden" />
                            </div>
                            
                            <!-- Extra filter optie - voorbeeld -->
                            <div class="w-full sm:w-1/4">
                                <label for="status" class="block text-sm font-medium text-[#735C49] mb-1">Status</label>
                                <select name="status" id="status" class="px-4 py-2 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full">
                                    <option value="">Alle</option>
                                    <option value="bezet" {{ request('status') == 'bezet' ? 'selected' : '' }}>Bezet</option>
                                    <option value="vrij" {{ request('status') == 'vrij' ? 'selected' : '' }}>Vrij</option>
                                </select>
                            </div>
                            
                            <div class="w-full sm:w-auto mt-4 sm:mt-6">
                                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] transition-colors duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Zoeken
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel van cellen -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-[#735C49]/30 rounded-lg shadow-md">
                            <thead class="bg-[#F7EADF] text-[#735C49]">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider">Celnaam</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider">Gedetineerde</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#735C49]/10">
                                @foreach($cellen ?? collect() as $cel)
                                    <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                        <td class="px-4 py-3 text-sm font-medium text-[#735C49]">{{ $cel->naam }}</td>
                                        <td class="px-4 py-3 text-sm text-[#735C49]">
                                            @if($cel->gedetineerde)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Bezet
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Vrij
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-[#735C49]">
                                            {{ $cel->gedetineerde ? $cel->gedetineerde->naam_gedetineerd . ' ' . ($cel->gedetineerde->achternaam_gedetineerd ?? '') : 'Geen' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex flex-col sm:flex-row justify-center gap-2">
                                                <!-- Verplaats link -->
                                                <a href="{{ route('cellen.verplaats', $cel->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-400 transition-colors duration-300 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m-8 6H4m0 0l4 4m-4-4l4-4" />
                                                    </svg>
                                                    Verplaats
                                                </a>
                                                <!-- Celgeschiedenis -->
                                                <a href="{{ route('cellen.geschiedenis', $cel->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-400 transition-colors duration-300 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Geschiedenis
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginering -->
                    <div class="mt-6">
                        {{ $cellen->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>