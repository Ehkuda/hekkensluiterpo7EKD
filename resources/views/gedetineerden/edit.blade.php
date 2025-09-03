<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <h1 class="text-3xl font-semibold text-[#735C49] mb-4 sm:mb-0">Gedetineerde Bewerken</h1>
                        
                        <a href="{{ route('gedetineerden.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Terug naar overzicht
                        </a>
                    </div>

                    <div class="bg-[#F7EADF]/40 p-6 rounded-lg border border-[#735C49]/20 shadow-sm">
                        <form action="{{ route('gedetineerden.update', $gedetineerde->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Persoonlijke informatie sectie -->
                            <div class="mb-8">
                                <h2 class="text-xl font-medium text-[#735C49] mb-4 pb-2 border-b border-[#735C49]/20">Persoonlijke Informatie</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Voornaam -->
                                    <div>
                                        <label for="naam_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Voornaam</label>
                                        <input type="text" name="naam_gedetineerd" id="naam_gedetineerd"
                                            value="{{ old('naam_gedetineerd', $gedetineerde->naam_gedetineerd) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>

                                    <!-- Achternaam -->
                                    <div>
                                        <label for="achternaam_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Achternaam</label>
                                        <input type="text" name="achternaam_gedetineerd" id="achternaam_gedetineerd"
                                            value="{{ old('achternaam_gedetineerd', $gedetineerde->achternaam_gedetineerd) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Geboortedatum -->
                                    <div>
                                        <label for="geboortedatum_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Geboortedatum</label>
                                        <input type="date" name="geboortedatum_gedetineerd" id="geboortedatum_gedetineerd"
                                            value="{{ old('geboortedatum_gedetineerd', $gedetineerde->geboortedatum_gedetineerd) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>

                                    <!-- Adres -->
                                    <div>
                                        <label for="adres_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Adres</label>
                                        <input type="text" name="adres_gedetineerd" id="adres_gedetineerd"
                                            value="{{ old('adres_gedetineerd', $gedetineerde->adres_gedetineerd) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Detentie informatie sectie -->
                            <div class="mb-8">
                                <h2 class="text-xl font-medium text-[#735C49] mb-4 pb-2 border-b border-[#735C49]/20">Detentie Informatie</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Delict -->
                                    <div>
                                        <label for="reden_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Delict</label>
                                        <input type="text" name="reden_gedetineerd" id="reden_gedetineerd"
                                            value="{{ old('reden_gedetineerd', $gedetineerde->reden_gedetineerd) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>

                                    <!-- Opmerkingen -->
                                    <div>
                                        <label for="opmerkingen" class="block text-sm font-medium text-[#735C49] mb-1">Opmerkingen</label>
                                        <textarea name="opmerkingen" id="opmerkingen" rows="3"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">{{ old('opmerkingen', $gedetineerde->opmerkingen) }}</textarea>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Datum van Opsluiting -->
                                    <div>
                                        <label for="datum_opsluiting" class="block text-sm font-medium text-[#735C49] mb-1">Datum van Opsluiting</label>
                                        <input type="date" name="datum_opsluiting" id="datum_opsluiting"
                                            value="{{ old('datum_opsluiting', $gedetineerde->datum_opsluiting) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>

                                    <!-- Datum van Vrijlating -->
                                    <div>
                                        <label for="datum_vrijlating" class="block text-sm font-medium text-[#735C49] mb-1">Datum van Vrijlating</label>
                                        <input type="date" name="datum_vrijlating" id="datum_vrijlating"
                                            value="{{ old('datum_vrijlating', $gedetineerde->datum_vrijlating) }}"
                                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    </div>
                                </div>

                                <!-- Verslag Upload -->
                                <div class="mb-6">
                                    <label for="verslag" class="block text-sm font-medium text-[#735C49] mb-1">Verslag uploaden</label>
                                    <input type="file" name="verslag" id="verslag"
                                        class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md">
                                    @if($gedetineerde->verslag_path)
                                        <p class="mt-2 text-sm">Huidig bestand: 
                                            <a href="{{ asset('storage/'.$gedetineerde->verslag_path) }}" target="_blank" class="text-blue-600 underline">
                                                Bekijk verslag
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-4">
                                <a href="{{ route('gedetineerden.index') }}"
                                class="w-full sm:w-auto text-center bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors duration-300 flex items-center justify-center">
                                    Annuleren
                                </a>

                                <button type="submit"
                                    class="w-full sm:w-auto bg-[#735C49] text-white px-6 py-2 rounded-md hover:bg-[#6a4e39] transition-colors duration-300 flex items-center justify-center">
                                    Wijzigingen opslaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
