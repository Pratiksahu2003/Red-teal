@extends('layouts.app')

@section('title', settings('website.default_page_title') ?? settings('company.company_name') ?? 'RedNTeal')

@section('content')
@include('components.hero-carousel', ['heroSlides' => $heroSlides])

{{-- Statistics --}}
@if($statistics->count())
<section class="py-14 lg:py-16 bg-white border-b border-brand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            @foreach($statistics as $stat)
                <div class="text-center">
                    <p class="font-display text-4xl lg:text-5xl text-brand-red-500 mb-2">{{ $stat->number }}</p>
                    <p class="font-medium text-brand-900">{{ $stat->label }}</p>
                    @if($stat->description)
                        <p class="text-sm text-brand-500 mt-1">{{ $stat->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Intro Section --}}
@if($homepage->intro_heading || $homepage->intro_description)
<section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div>
                <h2 class="font-display text-4xl lg:text-5xl text-brand-900 mb-6">{{ $homepage->intro_heading ?? 'Built for the Nordic Climate' }}</h2>
                <div class="prose-content text-brand-600 text-lg">{!! rich_content($homepage->intro_description) !!}</div>
            </div>
            <div class="relative">
                <img
                    src="{{ $homepage->intro_image ? Storage::url($homepage->intro_image) : asset('images/data-centre-facility.jpg') }}"
                    alt="{{ $homepage->intro_heading ?? 'RedNTeal data centre' }}"
                    class="rounded-2xl shadow-2xl w-full aspect-[4/3] object-cover"
                >
                <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-brand-teal-600/20 rounded-2xl -z-10"></div>
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-brand-red-500/10 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Benefits --}}
@if($benefits->count())
<section class="py-24 bg-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="font-display text-4xl text-brand-900 mb-4">Why RedNTeal</h2>
            <p class="text-brand-600">Sustainable infrastructure designed for enterprise performance and environmental responsibility.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($benefits as $benefit)
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition group">
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-100 flex items-center justify-center mb-5 group-hover:bg-brand-teal-600 transition">
                        <i data-lucide="{{ $benefit->icon ?? 'leaf' }}" class="w-6 h-6 text-brand-teal-700 group-hover:text-white transition"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-brand-900 mb-3">{{ $benefit->title }}</h3>
                    <p class="text-brand-600 leading-relaxed">{{ $benefit->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Sustainability --}}
@if($homepage->sustainability_heading || $homepage->sustainability_description)
<section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div>
                <p class="text-brand-teal-600 text-sm font-medium tracking-widest uppercase mb-4">Sustainability</p>
                <h2 class="font-display text-4xl lg:text-5xl text-brand-900 mb-6">{{ $homepage->sustainability_heading ?? '100% Renewable Energy' }}</h2>
                <div class="prose-content text-brand-600 text-lg mb-8">{!! rich_content($homepage->sustainability_description) !!}</div>
                @if($homepage->sustainability_cta_text)
                    <a href="{{ $homepage->sustainability_cta_url ?? route('about.index') }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium hover:text-brand-teal-600 transition">
                        {{ $homepage->sustainability_cta_text }}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
            <div class="relative">
                <img
                    src="{{ $homepage->sustainability_image ? Storage::url($homepage->sustainability_image) : asset('images/hero-slide-3.jpg') }}"
                    alt="{{ $homepage->sustainability_heading ?? 'Sustainability' }}"
                    class="rounded-2xl shadow-2xl w-full aspect-[4/3] object-cover"
                >
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-brand-teal-600/20 rounded-2xl -z-10"></div>
                <div class="absolute -top-4 -left-4 w-20 h-20 bg-brand-red-500/10 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Infrastructure --}}
@if($homepage->infrastructure_heading || $homepage->infrastructure_description)
<section class="py-24 bg-brand-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-4">Infrastructure</p>
                <h2 class="font-display text-4xl lg:text-5xl mb-6">{{ $homepage->infrastructure_heading ?? 'Enterprise-Grade Facilities' }}</h2>
                <div class="prose-content text-brand-300 text-lg">{!! rich_content($homepage->infrastructure_description) !!}</div>
            </div>
            @if($homepage->infrastructure_image)
                <img src="{{ Storage::url($homepage->infrastructure_image) }}" alt="" class="rounded-2xl shadow-2xl w-full aspect-[4/3] object-cover">
            @endif
        </div>
    </div>
</section>
@endif

{{-- Services Preview --}}
@if($services->count())
<section class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
            <div>
                <h2 class="font-display text-4xl text-brand-900 mb-2">Our Services</h2>
                <p class="text-brand-600">Comprehensive data centre solutions for modern enterprises.</p>
            </div>
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium hover:text-brand-teal-600 transition">
                View all services <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
                <a href="{{ route('services.show', $service) }}" class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl transition">
                    @if($service->featured_image)
                        <img src="{{ hero_image_url($service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-48 bg-brand-100 flex items-center justify-center">
                            <i data-lucide="{{ $service->icon ?? 'server' }}" class="w-12 h-12 text-brand-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $service->title }}</h3>
                        <p class="text-brand-600 text-sm">{{ Str::limit($service->short_description, 120) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Solutions Preview --}}
@if($solutions->count())
<section class="pt-24 pb-12 bg-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
            <div>
                <h2 class="font-display text-4xl text-brand-900 mb-2">Our Solutions</h2>
                <p class="text-brand-600">Tailored infrastructure for every scale and requirement.</p>
            </div>
            <a href="{{ route('solutions.index') }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium hover:text-brand-teal-600 transition">
                View all solutions <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($solutions as $solution)
                <a href="{{ route('solutions.show', $solution) }}" class="group bg-white rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-100 flex items-center justify-center mb-5 group-hover:bg-brand-teal-600 transition">
                        <i data-lucide="{{ $solution->icon ?? 'layers' }}" class="w-6 h-6 text-brand-teal-700 group-hover:text-white transition"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $solution->title }}</h3>
                    <p class="text-brand-600 text-sm">{{ Str::limit($solution->short_description, 120) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Latest Insights --}}
@if($latestPosts->count())
<section class="py-24 lg:py-32 bg-white border-t border-brand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
            <div>
                <p class="text-brand-teal-600 text-sm font-medium tracking-widest uppercase mb-2">Latest Insights</p>
                <h2 class="font-display text-4xl text-brand-900 mb-2">From Our Blog</h2>
                <p class="text-brand-600">Expert perspectives on sustainable data centres, cloud infrastructure, and Nordic digital innovation.</p>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium hover:text-brand-teal-600 transition shrink-0">
                View all articles <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($latestPosts as $post)
                <article class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl hover:border-brand-teal-200 transition flex flex-col">
                    <a href="{{ route('blog.show', $post) }}" class="block overflow-hidden">
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 text-xs text-brand-500 mb-2">
                            @if($post->category)
                                <span class="text-brand-teal-600 font-semibold uppercase tracking-wide">{{ $post->category->name }}</span>
                                <span>·</span>
                            @endif
                            @if($post->published_at)
                                <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('M j, Y') }}</time>
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">
                            <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-brand-600 text-sm leading-relaxed mb-4 flex-1">{{ Str::limit($post->excerpt, 120) }}</p>
                        <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm">
                            Read article <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Final CTA --}}
<section class="py-10 lg:py-12 border-t border-brand-200/60">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-display text-3xl lg:text-4xl text-brand-900 mb-3">
            {{ $homepage->final_cta_heading ?? 'Ready to build sustainably?' }}
        </h2>
        <p class="text-base text-brand-600 mb-5 max-w-2xl mx-auto leading-relaxed">
            {{ $homepage->final_cta_description ?? 'Partner with RedNTeal for Nordic data centre excellence powered by renewable energy.' }}
        </p>
        <a href="{{ $homepage->final_cta_button_url ?? route('contact.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-red-500 hover:bg-brand-red-600 text-white text-sm font-medium rounded-full transition shadow-md">
            {{ $homepage->final_cta_button_text ?? 'Get in Touch' }}
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>

@endsection
