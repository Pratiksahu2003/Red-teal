<nav x-data="{ open: false, servicesMenu: false, mobileServicesOpen: false }" @keydown.escape.window="open = false; servicesMenu = false" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-brand-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[4.5rem]">
            <x-logo class="h-9 lg:h-11 w-auto" />

            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Home</a>

                {{-- Services dropdown --}}
                <div class="relative" @click.outside="servicesMenu = false">
                    <button
                        type="button"
                        @click="servicesMenu = !servicesMenu"
                        class="inline-flex items-center gap-1 text-sm font-medium {{ request()->routeIs('services.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition"
                        :aria-expanded="servicesMenu"
                    >
                        Services
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="servicesMenu && 'rotate-180'"></i>
                    </button>

                    <div
                        x-show="servicesMenu"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute top-full left-0 mt-2 w-72 bg-white border border-brand-200 rounded-lg shadow-xl py-2 z-50"
                    >
                        @forelse($navServicesByCategory ?? [] as $category => $categoryServices)
                            <div class="px-2 py-1">
                                <p class="px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-brand-teal-600">{{ $category }}</p>
                                @foreach($categoryServices as $service)
                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        @click="servicesMenu = false"
                                        class="block px-3 py-2 text-sm text-brand-700 rounded-md hover:bg-brand-teal-50 hover:text-brand-teal-700 transition"
                                    >
                                        {{ $service->title }}
                                    </a>
                                @endforeach
                            </div>
                        @empty
                            <p class="px-4 py-3 text-sm text-brand-500">No services published yet.</p>
                        @endforelse
                        <div class="border-t border-brand-100 mt-1 px-2 pt-1">
                            <a
                                href="{{ route('services.index') }}"
                                @click="servicesMenu = false"
                                class="block px-3 py-2 text-sm font-medium text-brand-red-500 rounded-md hover:bg-brand-red-50 transition"
                            >
                                View All Services
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('solutions.index') }}" class="text-sm font-medium {{ request()->routeIs('solutions.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Solutions</a>
                <a href="{{ route('data-centre.index') }}" class="text-sm font-medium {{ request()->routeIs('data-centre.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Data Centre</a>
                <a href="{{ route('blog.index') }}" class="text-sm font-medium {{ request()->routeIs('blog.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Blog</a>
                <a href="{{ route('about.index') }}" class="text-sm font-medium {{ request()->routeIs('about.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">About</a>
                <a href="{{ route('contact.index') }}" class="px-5 py-2.5 bg-brand-red-500 text-white text-sm font-semibold rounded-sm hover:bg-brand-red-600 transition shadow-sm">Contact</a>
            </div>

            <button @click="open = !open" class="lg:hidden p-2 text-brand-700" aria-label="Toggle menu">
                <i data-lucide="menu" class="w-6 h-6" x-show="!open"></i>
                <i data-lucide="x" class="w-6 h-6" x-show="open" x-cloak></i>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="lg:hidden fixed inset-0 top-16 bg-brand-900/30 backdrop-blur-sm z-40" @click="open = false"></div>
    <div x-show="open" x-cloak x-transition class="lg:hidden absolute top-full left-0 right-0 bg-white border-b border-brand-200 shadow-lg z-50 max-h-[calc(100vh-4rem)] overflow-y-auto">
        <div class="px-4 py-6 space-y-4">
            <a href="{{ route('home') }}" class="block text-brand-700 font-medium py-2 hover:text-brand-red-500">Home</a>

            <div>
                <button
                    type="button"
                    @click="mobileServicesOpen = !mobileServicesOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2 hover:text-brand-red-500"
                >
                    <span>Services</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileServicesOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileServicesOpen" x-cloak x-transition class="mt-1 pl-3 border-l-2 border-brand-100 space-y-3">
                    @forelse($navServicesByCategory ?? [] as $category => $categoryServices)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-teal-600 mb-1">{{ $category }}</p>
                            <div class="space-y-1">
                                @foreach($categoryServices as $service)
                                    <a href="{{ route('services.show', $service) }}" @click="open = false" class="block text-sm text-brand-600 py-1 hover:text-brand-red-500">
                                        {{ $service->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-brand-500">No services published yet.</p>
                    @endforelse
                    <a href="{{ route('services.index') }}" @click="open = false" class="block text-sm font-medium text-brand-red-500 py-1">View All Services</a>
                </div>
            </div>

            <a href="{{ route('solutions.index') }}" class="block text-brand-700 font-medium py-2 hover:text-brand-red-500">Solutions</a>
            <a href="{{ route('data-centre.index') }}" class="block text-brand-700 font-medium py-2 hover:text-brand-red-500">Data Centre</a>
            <a href="{{ route('blog.index') }}" class="block text-brand-700 font-medium py-2 hover:text-brand-red-500">Blog</a>
            <a href="{{ route('about.index') }}" class="block text-brand-700 font-medium py-2 hover:text-brand-red-500">About</a>
            <a href="{{ route('contact.index') }}" class="block text-center px-5 py-3 bg-brand-red-500 text-white font-semibold rounded-sm">Contact</a>
        </div>
    </div>
</nav>
