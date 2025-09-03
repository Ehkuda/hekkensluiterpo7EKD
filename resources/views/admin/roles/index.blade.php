<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <h1 class="text-3xl font-semibold text-[#735C49] mb-4 sm:mb-0">Rollenbeheer</h1>
                        <a href="{{ route('admin.roles.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] transition-colors duration-300 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nieuwe Rol
                        </a>
                    </div>

                    <!-- Zoekbalk -->
                    <div class="mb-8 bg-[#F7EADF]/40 p-4 rounded-lg border border-[#735C49]/20">
                        <form method="GET" action="{{ route('admin.roles.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="w-full sm:w-1/2">
                                <label for="zoekterm" class="block text-sm font-medium text-[#735C49] mb-1">Zoekterm</label>
                                <input type="text" name="zoekterm" id="zoekterm" value="{{ request('zoekterm') }}" 
                                      class="px-4 py-2 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full" 
                                      placeholder="Zoek op naam of beschrijving" />
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

                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ session('error') }}
                            </p>
                        </div>
                    @endif

                    @if($roles->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Er zijn momenteel geen rollen in het systeem.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-[#735C49]/30 rounded-lg shadow-md">
                                <thead class="bg-[#F7EADF] text-[#735C49]">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider">Naam</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider">Beschrijving</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#735C49]/10">
                                    @foreach($roles as $role)
                                        <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                            <td class="px-4 py-3 text-sm font-medium text-[#735C49]">{{ $role->name }}</td>
                                            <td class="px-4 py-3 text-sm text-[#735C49]">{{ $role->description ?? 'Geen beschrijving' }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                                   class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-400 transition-colors duration-300 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Bewerken
                                                </a>
                                                @if (!in_array($role->name, ['directeur', 'coordinator', 'bewaker']))
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-400 transition-colors duration-300 text-sm ml-2"
                                                                onclick="return confirm('Weet je zeker dat je deze rol wilt verwijderen?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Verwijderen
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $roles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>