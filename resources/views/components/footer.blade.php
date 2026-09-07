<footer class="bg-white border-t border-brand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
        {{-- Brand + Certifications --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 pb-6 border-b border-brand-100">
            <div class="min-w-0 flex-1">
                <x-logo class="h-8 w-auto mb-2" />
                <p class="text-brand-teal-600 font-medium text-sm">{{ settings('company.tagline') ?? 'Technology You Can Trust' }}</p>
                <p class="text-brand-500 text-sm mt-1 max-w-lg leading-snug">{{ Str::limit(settings('company.description'), 140) }}</p>
                @if(count(settings('social_links') ?? []) > 0)
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach(settings('social_links') ?? [] as $link)
                            @if($link['is_active'] ?? false)
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $link['platform'] }}"
                                    class="w-8 h-8 rounded-full border border-brand-200 flex items-center justify-center text-brand-600 hover:text-brand-teal-600 hover:border-brand-teal-300 hover:bg-brand-teal-50 transition">
                                    <x-social-icon :name="$link['icon'] ?? $link['platform'] ?? 'link'" class="w-3.5 h-3.5" />
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:w-[min(100%,28rem)] shrink-0">
                <h4 class="text-brand-900 font-bold text-sm mb-2">Certifications</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach([
                        ['title' => 'ISO 27001', 'subtitle' => 'Security'],
                        ['title' => 'Tier III+', 'subtitle' => 'Certified'],
                        ['title' => '100% Renewable', 'subtitle' => 'Energy'],
                        ['title' => '99.999%', 'subtitle' => 'Uptime SLA'],
                    ] as $cert)
                        <div class="bg-brand-red-50 border border-brand-red-100 rounded-md px-2 py-2 text-center hover:border-brand-teal-200 hover:bg-brand-teal-50 transition">
                            <p class="text-brand-red-600 font-bold text-[11px] leading-tight">{{ $cert['title'] }}</p>
                            <p class="text-brand-teal-600 text-[10px] mt-0.5">{{ $cert['subtitle'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Link columns --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 pt-6">
            <div>
                <h4 class="text-brand-900 font-bold text-sm mb-2.5">Company</h4>
                <ul class="space-y-1.5">
                    @foreach([
                        ['label' => 'Home', 'url' => route('home')],
                        ['label' => 'About Us', 'url' => route('about.index')],
                        ['label' => 'Our Data Centre', 'url' => route('data-centre.index')],
                        ['label' => 'Blog', 'url' => route('blog.index')],
                        ['label' => 'Contact Us', 'url' => route('contact.index')],
                        ['label' => 'All Services', 'url' => route('services.index')],
                        ['label' => 'All Solutions', 'url' => route('solutions.index')],
                    ] as $item)
                        <li>
                            <a href="{{ $item['url'] }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm mb-2.5">Services</h4>
                <ul class="space-y-1.5">
                    <li>
                        <a href="{{ route('services.index') }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">View All Services</a>
                    </li>
                    @forelse($footerServices ?? [] as $service)
                        <li>
                            <a href="{{ route('services.show', $service) }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $service->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No services yet.</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm mb-2.5">Solutions</h4>
                <ul class="space-y-1.5">
                    <li>
                        <a href="{{ route('solutions.index') }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">View All Solutions</a>
                    </li>
                    @forelse($footerSolutions ?? [] as $solution)
                        <li>
                            <a href="{{ route('solutions.show', $solution) }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $solution->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No solutions yet.</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm mb-2.5">Contact</h4>
                <ul class="space-y-2">
                    @if(settings('company.address') || settings('company.city'))
                        <li class="flex items-start gap-2 text-sm text-brand-600">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-red-500 shrink-0 mt-0.5"></i>
                            <span class="leading-snug">
                                @if(settings('company.address')){{ settings('company.address') }}@endif
                                @if(settings('company.city'))
                                    @if(settings('company.address'))<br>@endif
                                    {{ settings('company.city') }}@if(settings('company.postal_code')), {{ settings('company.postal_code') }}@endif
                                @endif
                                @if(settings('company.country'))<br>{{ settings('company.country') }}@endif
                            </span>
                        </li>
                    @endif
                    @if(settings('company.phone'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="tel:{{ preg_replace('/\s+/', '', settings('company.phone')) }}" class="text-brand-600 hover:text-brand-red-500 transition">{{ settings('company.phone') }}</a>
                        </li>
                    @endif
                    @if(settings('company.secondary_phone'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="tel:{{ preg_replace('/\s+/', '', settings('company.secondary_phone')) }}" class="text-brand-600 hover:text-brand-red-500 transition">{{ settings('company.secondary_phone') }}</a>
                        </li>
                    @endif
                    @if(settings('company.email'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="mailto:{{ settings('company.email') }}" class="text-brand-600 hover:text-brand-red-500 transition break-all">{{ settings('company.email') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Sitemap --}}
        <div id="sitemap" class="mt-6 pt-5 border-t border-brand-100 scroll-mt-24">
            <h4 class="text-brand-900 font-bold text-xs uppercase tracking-wide mb-2">Sitemap</h4>
            <div class="flex flex-wrap gap-x-3 gap-y-1 text-sm leading-relaxed">
                <a href="{{ route('home') }}" class="text-brand-500 hover:text-brand-red-500 transition">Home</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('about.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">About</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('data-centre.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Data Centre</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('blog.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Blog</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('services.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Services</a>
                @foreach($footerServices ?? [] as $service)
                    <span class="text-brand-300 select-none">·</span>
                    <a href="{{ route('services.show', $service) }}" class="text-brand-500 hover:text-brand-red-500 transition">{{ $service->title }}</a>
                @endforeach
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('solutions.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Solutions</a>
                @foreach($footerSolutions ?? [] as $solution)
                    <span class="text-brand-300 select-none">·</span>
                    <a href="{{ route('solutions.show', $solution) }}" class="text-brand-500 hover:text-brand-red-500 transition">{{ $solution->title }}</a>
                @endforeach
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('contact.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Contact</a>
            </div>
        </div>
    </div>

    {{-- Sub-footer --}}
    <div class="border-t border-brand-200 bg-brand-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm">
                <div class="text-center sm:text-left">
                    <p class="text-brand-700">
                        &copy; {{ date('Y') }}
                        <span class="font-semibold text-brand-900">{{ settings('company.company_name') ?? 'RedNTeal' }}</span>.
                        All rights reserved.
                    </p>
                    @if(settings('company.founded_year'))
                        <p class="text-brand-500 text-xs mt-0.5">Serving clients worldwide since {{ settings('company.founded_year') }}</p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    <button
                        type="button"
                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-red-500 font-medium transition"
                    >
                        <i data-lucide="arrow-up" class="w-3.5 h-3.5"></i>
                        Back to Top
                    </button>
                    <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-red-500 font-medium transition">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                        Get Quote
                    </a>
                    <span class="hidden sm:inline text-brand-300">|</span>
                    <a href="{{ route('about.index') }}#privacy" class="text-brand-500 hover:text-brand-red-500 transition">Privacy</a>
                    <a href="{{ route('about.index') }}#terms" class="text-brand-500 hover:text-brand-red-500 transition">Terms</a>
                    <button
                        type="button"
                        onclick="localStorage.removeItem('cookie_accepted'); window.dispatchEvent(new CustomEvent('show-cookie-notice'))"
                        class="text-brand-500 hover:text-brand-red-500 transition"
                    >Cookies</button>
                    <a href="{{ route('home') }}#sitemap" class="text-brand-500 hover:text-brand-red-500 transition">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
