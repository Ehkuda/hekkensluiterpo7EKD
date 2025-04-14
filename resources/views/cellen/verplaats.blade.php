<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold text-[#735C49] mb-6 border-b border-[#735C49]/20 pb-2">Verplaats Gedetineerde</h1>
                    
                    <!-- Huidige cel & gedetineerde info -->
                    <div class="mb-8 p-4 bg-[#F7EADF]/40 rounded-lg border border-[#735C49]/20">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-[#735C49]/70 mb-1">Huidige Cel</h3>
                                <p class="text-lg font-medium text-[#735C49]">{{ $cel->naam }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-[#735C49]/70 mb-1">Huidige Gedetineerde</h3>
                                <p class="text-lg font-medium text-[#735C49]">
                                    {{ $cel->gedetineerde ? $cel->gedetineerde->naam_gedetineerd . ' ' . ($cel->gedetineerde->achternaam_gedetineerd ?? '') : 'Geen gedetineerde' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('cellen.verplaats', $cel->id) }}" class="bg-white rounded-lg shadow-sm">
                        @csrf
                        
                        <!-- Selectie voor nieuwe cel -->
                        <div class="mb-6">
                            <label for="cel_id" class="block font-medium text-[#735C49] mb-2">Kies een nieuwe cel</label>
                            <select name="cel_id" id="cel_id" class="px-4 py-3 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full">
                                <option value="">-- Selecteer een cel --</option>
                                @foreach($beschikbareCellen as $celOptie)
                                    <option value="{{ $celOptie->id }}">{{ $celOptie->naam }}</option>
                                @endforeach
                            </select>
                            
                            @error('cel_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Opmerking veld (optioneel) -->
                        <div class="mb-6">
                            <label for="opmerking" class="block font-medium text-[#735C49] mb-2">Opmerking (optioneel)</label>
                            <textarea name="opmerking" id="opmerking" rows="3" class="px-4 py-3 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full"></textarea>
                        </div>

                        <!-- Verplaats knop & annuleer -->
                        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <button type="submit" class="px-6 py-3 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] flex items-center justify-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m-8 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Verplaats Gedetineerde
                            </button>
                            <a href="{{ route('cellen.index') }}" class="px-6 py-3 bg-gray-200 text-[#735C49] rounded-md hover:bg-gray-300 flex items-center justify-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Annuleren
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
