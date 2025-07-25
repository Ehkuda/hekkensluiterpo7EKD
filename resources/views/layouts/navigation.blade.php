<nav x-data="{ open: false }" class="bg-white border-b border-[#735C49]/20 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#735C49]" />
                        <span class="font-semibold text-[#735C49] hidden md:block">Hekkensluiter Beheer</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-4 sm:-my-px sm:ms-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:bg-[#F7EADF] text-[#735C49] px-3 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('gedetineerden.index')" :active="request()->routeIs('gedetineerden.*')" class="hover:bg-[#F7EADF] text-[#735C49] px-3 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Gedetineerden') }}
                    </x-nav-link>

                    <x-nav-link :href="route('cellen.index')" :active="request()->routeIs('cellen.*')" class="hover:bg-[#F7EADF] text-[#735C49] px-3 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Cellen') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="hover:bg-[#F7EADF] text-[#735C49] px-3 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Beheer') }}
                    </x-nav-link>

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-[#735C49]/20 text-sm leading-4 font-medium rounded-md text-[#735C49] bg-white hover:text-[#6a4e39] focus:outline-none focus:border-[#735C49]/50 transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-[#F7EADF]">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" 
                                onclick="event.preventDefault();
                                          this.closest('form').submit();" class="hover:bg-[#F7EADF]">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#735C49] hover:text-[#6a4e39] hover:bg-[#F7EADF] focus:outline-none focus:bg-[#F7EADF] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#735C49] hover:bg-[#F7EADF]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('gedetineerden.index')" :active="request()->routeIs('gedetineerden.*')" class="text-[#735C49] hover:bg-[#F7EADF]">
                {{ __('Gedetineerden') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cellen.index')" :active="request()->routeIs('cellen.*')" class="text-[#735C49] hover:bg-[#F7EADF]">
                {{ __('Cellen') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#735C49]/20">
            <div class="px-4">
                <div class="font-medium text-base text-[#735C49]">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-[#735C49]/70">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-[#735C49] hover:bg-[#F7EADF]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" 
                        onclick="event.preventDefault();
                                  this.closest('form').submit();" class="text-[#735C49] hover:bg-[#F7EADF]">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>