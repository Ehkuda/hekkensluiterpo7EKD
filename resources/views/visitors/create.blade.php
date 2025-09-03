<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe Bezoeker Registreren') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('visitors.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="id_document_number" class="block text-sm font-medium text-gray-700">ID-nummer</label>
                            <input type="text" name="id_document_number" id="id_document_number" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('id_document_number') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="detainee_id" class="block text-sm font-medium text-gray-700">Gedetineerde</label>
                            <select name="detainee_id" id="detainee_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                <option value="">Selecteer een gedetineerde</option>
                                @foreach ($gedetineerden as $gedetineerde)
                                    <option value="{{ $gedetineerde->id }}">{{ $gedetineerde->naam_gedetineerd }} {{ $gedetineerde->achternaam_gedetineerd }}</option>
                                @endforeach
                            </select>
                            @error('detainee_id') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="arrival_time" class="block text-sm font-medium text-gray-700">Aankomsttijd</label>
                            <input type="datetime-local" name="arrival_time" id="arrival_time" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('arrival_time') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Registreren</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>