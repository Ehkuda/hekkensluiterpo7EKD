<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <h1 class="text-3xl font-semibold text-[#735C49] mb-4 sm:mb-0">Nieuwe Rol Aanmaken</h1>
                        <a href="{{ route('admin.roles.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-400 transition-colors duration-300 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Terug
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-[#735C49] mb-1">Rol Naam <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       class="px-4 py-2 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full @error('name') border-red-500 @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Voer rolnaam in"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-[#735C49] mb-1">Beschrijving</label>
                                <input type="text" 
                                       class="px-4 py-2 border border-[#735C49]/30 rounded-md focus:outline-none focus:ring-2 focus:ring-[#735C49] w-full @error('description') border-red-500 @enderror" 
                                       id="description" 
                                       name="description" 
                                       value="{{ old('description') }}"
                                       placeholder="Voer beschrijving in">
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        @if($permissions->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-[#735C49] mb-4">Rechten toewijzen</h3>
                            <div class="bg-[#F7EADF]/40 p-4 rounded-lg border border-[#735C49]/20">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="permission_{{ $permission->id }}" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->id }}"
                                                   class="h-4 w-4 text-[#735C49] focus:ring-[#735C49] border-[#735C49]/30 rounded"
                                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                            <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-[#735C49]">
                                                {{ $permission->name }}
                                                @if($permission->description)
                                                    <span class="text-gray-500 text-xs block">{{ $permission->description }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="mt-6 flex space-x-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 bg-[#735C49] text-white rounded-md hover:bg-[#6a4e39] transition-colors duration-300 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Rol Aanmaken
                            </button>
                            <a href="{{ route('admin.roles.index') }}" 
                               class="inline-flex items-center px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-400 transition-colors duration-300 text-sm font-medium">
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