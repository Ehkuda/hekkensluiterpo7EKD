<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beheersmodule Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats overzicht -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Gebruikers stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Gebruikers</h2>
                                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rollen stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Rollen</h2>
                                <p class="text-3xl font-bold">{{ $totalRoles }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Gedetineerden stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#F7EADF] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#735C49]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#735C49]">Gedetineerden</h2>
                                <p class="text-3xl font-bold">{{ $totalGedetineerden }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recente gebruikers -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-[#735C49]">Recente Gebruikers</h2>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] transition-colors duration-300 text-sm">Alle Gebruikers</a>
                    </div>
                    
                    @if($recentUsers->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Er zijn momenteel geen gebruikers in het systeem.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-[#F7EADF] text-[#735C49]">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Naam</th>
                                        <th class="px-4 py-2 text-left">Email</th>
                                        <th class="px-4 py-2 text-left">Rollen</th>
                                        <th class="px-4 py-2 text-left">Aangemaakt</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#735C49]/10">
                                    @foreach($recentUsers as $user)
                                        <tr class="hover:bg-[#F7EADF]/30 transition-colors duration-150">
                                            <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                                            <td class="px-4 py-2">{{ $user->email }}</td>
                                            <td class="px-4 py-2">
                                                @foreach($user->roles as $role)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mr-1">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                                @if($user->roles->isEmpty())
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Geen rollen
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-[#735C49] mb-4">Snelle Acties</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Nieuwe Gebruiker</p>
                                </div>
                            </a>
                            <a href="{{ route('admin.roles.index') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Beheer Rollen</p>
                                </div>
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Overzicht Gebruikers</p>
                                </div>
                            </a>
                            <a href="{{ route('gedetineerden.index') }}" class="flex items-center p-4 bg-[#F7EADF]/40 rounded-lg hover:bg-[#F7EADF] transition-colors duration-300">
                                <div class="flex-shrink-0 bg-[#735C49] p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[#735C49] font-medium">Overzicht Gedetineerden</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-[#735C49] mb-4">Systeem Overzicht</h2>
                        <div class="flex flex-col space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Actieve Gebruikers</span>
                                <span class="font-semibold">{{ $totalUsers }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Gedefinieerde Rollen</span>
                                <span class="font-semibold">{{ $totalRoles }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Toegewezen Rechten</span>
                                <span class="font-semibold">{{ $totalPermissions }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#735C49] font-medium">Gedetineerden</span>
                                <span class="font-semibold">{{ $totalGedetineerden }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>