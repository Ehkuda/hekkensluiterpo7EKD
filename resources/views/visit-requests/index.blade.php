<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bezoekverzoeken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Filter buttons -->
                    <div class="mb-6 flex flex-wrap gap-2">
                        <a href="{{ route('visit-requests.index', ['status' => 'all']) }}" 
                           class="px-4 py-2 rounded {{ $status === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Alle verzoeken
                        </a>
                        <a href="{{ route('visit-requests.index', ['status' => 'pending']) }}" 
                           class="px-4 py-2 rounded {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            In afwachting
                        </a>
                        <a href="{{ route('visit-requests.index', ['status' => 'approved']) }}" 
                           class="px-4 py-2 rounded {{ $status === 'approved' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Goedgekeurd
                        </a>
                        <a href="{{ route('visit-requests.index', ['status' => 'rejected']) }}" 
                           class="px-4 py-2 rounded {{ $status === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Afgewezen
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Requests table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bezoeker
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gedetineerde
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gewenste tijd
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ingediend op
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acties
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($requests as $request)
                                    <tr class="{{ $request->isPending() ? 'bg-yellow-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $request->visitor_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $request->visitor_email }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $request->detainee->naam_gedetineerd }} 
                                                {{ $request->detainee->achternaam_gedetineerd }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->requested_visit_time->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $request->getStatusDisplayName() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('visit-requests.show', $request) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                Details
                                            </a>
                                            
                                            @if($request->isPending())
                                                @can('visit-requests.approve')
                                                    <a href="{{ route('visit-requests.approval', $request) }}" 
                                                       class="text-green-600 hover:text-green-900">
                                                        Behandelen
                                                    </a>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Geen bezoekverzoeken gevonden.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $requests->appends(['status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>