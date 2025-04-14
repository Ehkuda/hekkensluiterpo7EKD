<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-[#735C49] leading-tight">
            Gedetineerde Toevoegen
        </h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto">
        <form action="{{ route('gedetineerden.store') }}" method="POST" class="bg-[#F7EADF] p-8 rounded-2xl shadow-lg space-y-8">
            @csrf

            <!-- Persoonlijke Informatie Sectie -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#735C49]/20">
                <h3 class="text-xl font-medium text-[#735C49] mb-6 border-b pb-2">Persoonlijke Informatie</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="naam_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Voornaam</label>
                        <input type="text" name="naam_gedetineerd" id="naam_gedetineerd"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('naam_gedetineerd') border-red-500 @enderror" required>
                        @error('naam_gedetineerd')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="achternaam_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Achternaam</label>
                        <input type="text" name="achternaam_gedetineerd" id="achternaam_gedetineerd"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('achternaam_gedetineerd') border-red-500 @enderror" required>
                        @error('achternaam_gedetineerd')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="geboortedatum_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Geboortedatum</label>
                        <input type="date" name="geboortedatum_gedetineerd" id="geboortedatum_gedetineerd"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('geboortedatum_gedetineerd') border-red-500 @enderror" required>
                        @error('geboortedatum_gedetineerd')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="adres_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Adres</label>
                        <input type="text" name="adres_gedetineerd" id="adres_gedetineerd"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('adres_gedetineerd') border-red-500 @enderror" required>
                        @error('adres_gedetineerd')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="id_nummer" class="block text-sm font-medium text-[#735C49] mb-1">ID Nummer</label>
                    <input type="text" name="id_nummer" id="id_nummer"
                        class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('id_nummer') border-red-500 @enderror" required>
                    @error('id_nummer')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Detentie Informatie Sectie -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#735C49]/20">
                <h3 class="text-xl font-medium text-[#735C49] mb-6 border-b pb-2">Detentie Informatie</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="reden_gedetineerd" class="block text-sm font-medium text-[#735C49] mb-1">Delict</label>
                        <input type="text" name="reden_gedetineerd" id="reden_gedetineerd"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('reden_gedetineerd') border-red-500 @enderror" required>
                        @error('reden_gedetineerd')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="cel_id" class="block text-sm font-medium text-[#735C49] mb-1">Kies een vrije cel</label>
                        <select name="cel_id" id="cel_id"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('cel_id') border-red-500 @enderror" required>
                            @foreach($beschikbareCellen as $cel)
                                <option value="{{ $cel->id }}">{{ $cel->naam }}</option>
                            @endforeach
                        </select>
                        @error('cel_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="datum_opsluiting" class="block text-sm font-medium text-[#735C49] mb-1">Datum Opsluiting</label>
                        <input type="date" name="datum_opsluiting" id="datum_opsluiting"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('datum_opsluiting') border-red-500 @enderror" required>
                        @error('datum_opsluiting')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="datum_vrijlating" class="block text-sm font-medium text-[#735C49] mb-1">Datum Vrijlating</label>
                        <input type="date" name="datum_vrijlating" id="datum_vrijlating"
                            class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('datum_vrijlating') border-red-500 @enderror">
                        @error('datum_vrijlating')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="opmerkingen" class="block text-sm font-medium text-[#735C49] mb-1">Opmerkingen</label>
                    <textarea name="opmerkingen" id="opmerkingen" rows="4"
                        class="w-full border border-[#735C49]/30 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] @error('opmerkingen') border-red-500 @enderror"></textarea>
                    @error('opmerkingen')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="submit" class="bg-[#735C49] text-white px-8 py-4 rounded-lg hover:bg-[#5b4636] transition-colors duration-300">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
