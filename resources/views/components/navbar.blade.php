<nav x-data="{ open: false, servicesMenu: false, solutionsMenu: false, blogMenu: false, mobileServicesOpen: false, mobileSolutionsOpen: false, mobileBlogOpen: false }" @keydown.escape.window="open = false; servicesMenu = false; solutionsMenu = false; blogMenu = false" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-brand-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[4.75rem] lg:h-20">
            <x-logo class="h-14 lg:h-16 w-auto max-w-none" />

            <div class="hidden lg:flex items-center gap-6 xl:gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Home</a>

                {{-- Services mega menu --}}
                <div class="relative" @click.outside="servicesMenu = false">
                    <button
                        type="button"
                        @click="solutionsMenu = false; blogMenu = false; servicesMenu = !servicesMenu"
                        class="inline-flex items-center gap-1.5 text-sm font-medium rounded-lg px-2.5 py-1.5 transition"
                        :class="servicesMenu
                            ? 'text-brand-teal-700 ring-2 ring-brand-teal-500/25 bg-brand-teal-50/50'
                            : ({{ request()->routeIs('services.*') ? 'true' : 'false' }}
                                ? 'text-brand-red-500 hover:text-brand-red-600'
                                : 'text-brand-600 hover:text-brand-teal-600')"
                        :aria-expanded="servicesMenu"
                    >
                        Services
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="servicesMenu && 'rotate-180'"></i>
                    </button>

                    <div
                        x-show="servicesMenu"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full left-1/2 -translate-x-1/2 pt-3 z-50"
                    >
                        <div class="w-[min(94vw,920px)] rounded-2xl bg-white border border-brand-200/80 shadow-2xl shadow-brand-900/10 overflow-hidden">
                            <div class="p-6 lg:p-8">
                                @if(($navServicesByCategory ?? collect())->isNotEmpty())
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-8">
                                        @foreach($navServicesByCategory as $category => $categoryServices)
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-brand-900 mb-3 leading-snug">{{ $category }}</p>
                                                <ul class="space-y-2">
                                                    @foreach($categoryServices as $service)
                                                        <li>
                                                            <a
                                                                href="{{ route('services.show', $service) }}"
                                                                @click="servicesMenu = false"
                                                                class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                            >
                                                                {{ $service->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-brand-500 py-4 text-center">No services published yet.</p>
                                @endif
                            </div>
                            <div class="px-6 lg:px-8 py-4 bg-brand-50/80 border-t border-brand-100">
                                <a
                                    href="{{ route('services.index') }}"
                                    @click="servicesMenu = false"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                                >
                                    View All Services
                                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Solutions mega menu --}}
                <div class="relative" @click.outside="solutionsMenu = false">
                    <button
                        type="button"
                        @click="servicesMenu = false; blogMenu = false; solutionsMenu = !solutionsMenu"
                        class="inline-flex items-center gap-1.5 text-sm font-medium rounded-lg px-2.5 py-1.5 transition"
                        :class="solutionsMenu
                            ? 'text-brand-teal-700 ring-2 ring-brand-teal-500/25 bg-brand-teal-50/50'
                            : ({{ request()->routeIs('solutions.*') ? 'true' : 'false' }}
                                ? 'text-brand-red-500 hover:text-brand-red-600'
                                : 'text-brand-600 hover:text-brand-teal-600')"
                        :aria-expanded="solutionsMenu"
                    >
                        Solutions
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="solutionsMenu && 'rotate-180'"></i>
                    </button>

                    <div
                        x-show="solutionsMenu"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full left-1/2 -translate-x-1/2 pt-3 z-50"
                    >
                        <div class="w-[min(94vw,720px)] rounded-2xl bg-white border border-brand-200/80 shadow-2xl shadow-brand-900/10 overflow-hidden">
                            <div class="p-6 lg:p-8">
                                @if(($navSolutionsByCategory ?? collect())->isNotEmpty())
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-8 gap-y-8">
                                        @foreach($navSolutionsByCategory as $category => $categorySolutions)
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-brand-900 mb-3 leading-snug">{{ $category }}</p>
                                                <ul class="space-y-2">
                                                    @foreach($categorySolutions as $solution)
                                                        <li>
                                                            <a
                                                                href="{{ route('solutions.show', $solution) }}"
                                                                @click="solutionsMenu = false"
                                                                class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                            >
                                                                {{ $solution->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-brand-500 py-4 text-center">No solutions published yet.</p>
                                @endif
                            </div>
                            <div class="px-6 lg:px-8 py-4 bg-brand-50/80 border-t border-brand-100">
                                <a
                                    href="{{ route('solutions.index') }}"
                                    @click="solutionsMenu = false"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                                >
                                    View All Solutions
                                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Blog mega menu --}}
                <div class="relative" @click.outside="blogMenu = false">
                    <button
                        type="button"
                        @click="servicesMenu = false; solutionsMenu = false; blogMenu = !blogMenu"
                        class="inline-flex items-center gap-1.5 text-sm font-medium rounded-lg px-2.5 py-1.5 transition"
                        :class="blogMenu
                            ? 'text-brand-teal-700 ring-2 ring-brand-teal-500/25 bg-brand-teal-50/50'
                            : ({{ request()->routeIs('blog.*') ? 'true' : 'false' }}
                                ? 'text-brand-red-500 hover:text-brand-red-600'
                                : 'text-brand-600 hover:text-brand-teal-600')"
                        :aria-expanded="blogMenu"
                    >
                        Blog
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="blogMenu && 'rotate-180'"></i>
                    </button>

                    <div
                        x-show="blogMenu"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full left-1/2 -translate-x-1/2 pt-3 z-50"
                    >
                        <div class="w-[min(94vw,920px)] rounded-2xl bg-white border border-brand-200/80 shadow-2xl shadow-brand-900/10 overflow-hidden">
                            <div class="p-6 lg:p-8">
                                @if(($navBlogByCategory ?? collect())->isNotEmpty())
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-8">
                                        @foreach($navBlogByCategory as $group)
                                            <div class="min-w-0">
                                                <a
                                                    href="{{ route('blog.index', ['category' => $group['slug']]) }}"
                                                    @click="blogMenu = false"
                                                    class="text-sm font-bold text-brand-900 mb-3 leading-snug hover:text-brand-teal-700 transition block"
                                                >
                                                    {{ $group['name'] }}
                                                </a>
                                                <ul class="space-y-2">
                                                    @foreach($group['posts'] as $post)
                                                        <li>
                                                            <a
                                                                href="{{ route('blog.show', $post) }}"
                                                                @click="blogMenu = false"
                                                                class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                            >
                                                                {{ $post->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-brand-500 py-4 text-center">No blog posts published yet.</p>
                                @endif
                            </div>
                            <div class="px-6 lg:px-8 py-4 bg-brand-50/80 border-t border-brand-100">
                                <a
                                    href="{{ route('blog.index') }}"
                                    @click="blogMenu = false"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                                >
                                    View All Articles
                                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('data-centre.index') }}" class="text-sm font-medium {{ request()->routeIs('data-centre.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Data Centre</a>
                <a href="{{ route('about.index') }}" class="text-sm font-medium {{ request()->routeIs('about.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">About</a>
                <a href="{{ route('contact.index') }}" class="px-5 py-2.5 bg-brand-red-500 text-white text-sm font-semibold rounded-sm hover:bg-brand-red-600 transition shadow-sm">Contact</a>
            </div>

            <button @click="open = !open" class="lg:hidden p-2 text-brand-700" aria-label="Toggle menu">
                <i data-lucide="menu" class="w-6 h-6" x-show="!open"></i>
                <i data-lucide="x" class="w-6 h-6" x-show="open" x-cloak></i>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="lg:hidden fixed inset-0 top-[4.75rem] bg-brand-900/30 backdrop-blur-sm z-40" @click="open = false"></div>
    <div x-show="open" x-cloak x-transition class="lg:hidden absolute top-full left-0 right-0 bg-white border-b border-brand-200 shadow-lg z-50 max-h-[calc(100vh-4.75rem)] overflow-y-auto">
        <div class="px-4 py-6 space-y-1">
            <a href="{{ route('home') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">Home</a>

            {{-- Mobile Services --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileSolutionsOpen = false; mobileBlogOpen = false; mobileServicesOpen = !mobileServicesOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Services</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileServicesOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileServicesOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navServicesByCategory ?? [] as $category => $categoryServices)
                        <div>
                            <p class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2">{{ $category }}</p>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($categoryServices as $service)
                                    <a href="{{ route('services.show', $service) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $service->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-brand-500">No services published yet.</p>
                    @endforelse
                    <a href="{{ route('services.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Services <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            {{-- Mobile Solutions --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileServicesOpen = false; mobileBlogOpen = false; mobileSolutionsOpen = !mobileSolutionsOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Solutions</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileSolutionsOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileSolutionsOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navSolutionsByCategory ?? [] as $category => $categorySolutions)
                        <div>
                            <p class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2">{{ $category }}</p>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($categorySolutions as $solution)
                                    <a href="{{ route('solutions.show', $solution) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $solution->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-brand-500">No solutions published yet.</p>
                    @endforelse
                    <a href="{{ route('solutions.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Solutions <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            {{-- Mobile Blog --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileServicesOpen = false; mobileSolutionsOpen = false; mobileBlogOpen = !mobileBlogOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Blog</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileBlogOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileBlogOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navBlogByCategory ?? [] as $group)
                        <div>
                            <a href="{{ route('blog.index', ['category' => $group['slug']]) }}" @click="open = false" class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2 block hover:text-brand-teal-700">
                                {{ $group['name'] }}
                            </a>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($group['posts'] as $post)
                                    <a href="{{ route('blog.show', $post) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $post->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-brand-500">No blog posts published yet.</p>
                    @endforelse
                    <a href="{{ route('blog.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Articles <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <a href="{{ route('data-centre.index') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">Data Centre</a>
            <a href="{{ route('about.index') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">About</a>
            <a href="{{ route('contact.index') }}" class="block text-center mt-4 px-5 py-3 bg-brand-red-500 text-white font-semibold rounded-sm">Contact</a>
        </div>
    </div>
</nav>
