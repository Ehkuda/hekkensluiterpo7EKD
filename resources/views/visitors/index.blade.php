<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bezoekers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('visitors.index') }}">
                        <input type="text" name="zoekterm" value="{{ $zoekterm ?? '' }}" placeholder="Zoek op naam of ID-nummer" class="border p-2 rounded">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Zoeken</button>
                    </form>

                    @can('role:bewaker|coordinator|directeur')
                        <a href="{{ route('visitors.create') }}" class="bg-green-500 text-white p-2 rounded mt-4 inline-block">Nieuwe Bezoeker</a>
                    @endcan

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>ID-nummer</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitor)
                                <tr>
                                    <td>{{ $visitor->name }}</td>
                                    <td>{{ $visitor->id_document_number }}</td>
                                    <td>
                                        <a href="{{ route('visitors.show', $visitor->id) }}" class="text-blue-500">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $visitors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>