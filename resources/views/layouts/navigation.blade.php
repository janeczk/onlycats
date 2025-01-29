<nav x-data="{ open: false }" class="bg-white border-r border-gray-100 h-screen fixed top-0 left-0 w-[30%] flex flex-col justify-between overflow-y-auto">
    <!-- Primary Navigation Menu -->
    <div class="px-8 sm:px-6 lg:px-8 flex flex-col">
        <div class="flex flex-col space-y-6 px-6">
            <div class="flex flex-col space-y-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center justify-end pt-6">
                    <a href="{{ route('home') }}">
                        <div class="transform scale-125">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col items-start space-y-4 self-end pr-6">
                    <!-- Home Link -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-lg flex items-center space-x-2 {{ request()->routeIs('home') ? 'text-black font-bold' : 'text-gray-500'}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>{{ __('Home') }}</span>
                    </x-nav-link>

                    <!-- Subs -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg flex items-center space-x-2 {{ request()->routeIs('dashboard') ? 'text-black font-bold' : 'text-gray-500' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        <span>{{ __('Subscribe') }}</span>
                    </x-nav-link>


                    <!-- Add Card -->
                    <x-nav-link
                        :href="route('add-card', ['from' => 'add-card'])"
                        :active="request()->routeIs('add-card')"
                        class="text-lg flex items-center space-x-2 {{ request()->routeIs('add-card') ? 'text-black font-bold' : 'text-gray-500' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>
                        <span>{{ __('Add Card') }}</span>
                    </x-nav-link>



                    <!-- Profile -->
                    <x-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.show')" class="text-lg flex items-center space-x-2 {{ request()->routeIs('profile.show') ? 'text-black font-bold' : 'text-gray-500' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>{{ __('Profile') }}</span>
                    </x-nav-link>

                    <!-- Log Out -->
                    <x-nav-link href="#" class="text-lg flex items-center space-x-2 text-gray-500 hover:text-gray-700 transition" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25-2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        <span>{{ __('Log Out') }}</span>
                    </x-nav-link>

                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>




                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    @auth
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    @endauth
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
