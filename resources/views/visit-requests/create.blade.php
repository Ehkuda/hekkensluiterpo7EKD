<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bezoekverzoek Indienen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg">
            <div class="bg-blue-600 text-white p-6 rounded-t-lg">
                <h1 class="text-2xl font-bold">Bezoekverzoek Indienen</h1>
                <p class="mt-2">Vul onderstaand formulier in om een bezoekverzoek aan een gedetineerde in te dienen.</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('visit-requests.store') }}">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="visitor_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Uw volledige naam *
                            </label>
                            <input type="text" 
                                   name="visitor_name" 
                                   id="visitor_name" 
                                   value="{{ old('visitor_name') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('visitor_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="visitor_id_document" class="block text-sm font-medium text-gray-700 mb-2">
                                ID-nummer (BSN/Paspoort) *
                            </label>
                            <input type="text" 
                                   name="visitor_id_document" 
                                   id="visitor_id_document" 
                                   value="{{ old('visitor_id_document') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('visitor_id_document')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="visitor_email" class="block text-sm font-medium text-gray-700 mb-2">
                                E-mailadres *
                            </label>
                            <input type="email" 
                                   name="visitor_email" 
                                   id="visitor_email" 
                                   value="{{ old('visitor_email') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('visitor_email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="visitor_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefoonnummer
                            </label>
                            <input type="tel" 
                                   name="visitor_phone" 
                                   id="visitor_phone" 
                                   value="{{ old('visitor_phone') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('visitor_phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="detainee_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Gedetineerde die u wilt bezoeken *
                        </label>
                        <select name="detainee_id" 
                                id="detainee_id" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            <option value="">Selecteer een gedetineerde</option>
                            @foreach ($gedetineerden as $gedetineerde)
                                <option value="{{ $gedetineerde->id }}" {{ old('detainee_id') == $gedetineerde->id ? 'selected' : '' }}>
                                    {{ $gedetineerde->naam_gedetineerd }} {{ $gedetineerde->achternaam_gedetineerd }}
                                </option>
                            @endforeach
                        </select>
                        @error('detainee_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="requested_visit_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Gewenste bezoektijd *
                        </label>
                        <input type="datetime-local" 
                               name="requested_visit_time" 
                               id="requested_visit_time" 
                               value="{{ old('requested_visit_time') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('requested_visit_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="reason_for_visit" class="block text-sm font-medium text-gray-700 mb-2">
                            Reden voor bezoek (optioneel)
                        </label>
                        <textarea name="reason_for_visit" 
                                  id="reason_for_visit" 
                                  rows="4" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Bijv. familie bezoek, juridische zaken, etc.">{{ old('reason_for_visit') }}</textarea>
                        @error('reason_for_visit')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-md mb-6">
                        <h3 class="font-medium text-yellow-800 mb-2">Belangrijk:</h3>
                        <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                            <li>Uw verzoek wordt beoordeeld door onze medewerkers</li>
                            <li>U ontvangt binnen 2 werkdagen bericht over de beslissing</li>
                            <li>Neem een geldig identiteitsbewijs mee bij het bezoek</li>
                            <li>Bezoektijden zijn van maandag t/m vrijdag 14:00-16:00</li>
                        </ul>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-md transition duration-200">
                            Bezoekverzoek Indienen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>