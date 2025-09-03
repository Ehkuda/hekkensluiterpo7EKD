<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bezoeker: ') . $visitor->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Gegevens</h3>
                    <p><strong>Naam:</strong> {{ $visitor->name }}</p>
                    <p><strong>ID-nummer:</strong> {{ $visitor->id_document_number }}</p>

                    <h3 class="text-lg font-semibold mt-4">Bezoekmomenten</h3>
                    <table class="min-w-full mt-2">
                        <thead>
                            <tr>
                                <th>Gedetineerde</th>
                                <th>Aankomst</th>
                                <th>Vertrek</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitor->visits as $visit)
                                <tr>
                                    <td>{{ $visit->detainee->naam_gedetineerd }} {{ $visit->detainee->achternaam_gedetineerd }}</td>
                                    <td>{{ $visit->arrival_time->format('d-m-Y H:i') }}</td>
                                    <td>{{ $visit->departure_time ? $visit->departure_time->format('d-m-Y H:i') : 'Nog niet vertrokken' }}</td>
                                    <td>
                                        @if (!$visit->departure_time)
                                            <form action="{{ route('visits.updateDeparture', $visit->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="datetime-local" name="departure_time" required class="border p-1 rounded">
                                                <button type="submit" class="bg-blue-500 text-white p-1 rounded">Vertrektijd Registreren</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>