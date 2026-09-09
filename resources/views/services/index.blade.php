@extends('layouts.app')

@section('title', 'Services — ' . (settings('company.company_name') ?? 'VDC800'))

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="Our Services" size="md">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">What We Offer</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4 max-w-3xl">Our Services</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">Enterprise data centre services built on Nordic sustainability principles and world-class infrastructure.</p>
</x-page-hero>

<section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($services->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl hover:border-brand-teal-200 transition">
                        @if($service->featured_image)
                            <img src="{{ hero_image_url($service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-brand-100 to-brand-teal-50 flex items-center justify-center">
                                <i data-lucide="{{ $service->icon ?? 'server' }}" class="w-14 h-14 text-brand-teal-500/60"></i>
                            </div>
                        @endif
                        <div class="p-6 lg:p-7">
                            @if($service->category)
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-brand-teal-600 mb-2">{{ $service->category }}</p>
                            @endif
                            <h2 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $service->title }}</h2>
                            <p class="text-brand-600 text-sm leading-relaxed mb-4">{{ $service->short_description }}</p>
                            <span class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm">
                                Learn more <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="server" class="w-16 h-16 mx-auto text-brand-300 mb-4"></i>
                <p class="text-brand-600">Services coming soon.</p>
            </div>
        @endif
    </div>
</section>

<section class="py-10 lg:py-12 border-t border-brand-200 bg-brand-50">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="font-display text-2xl lg:text-3xl text-brand-900 mb-3">Need a custom solution?</h2>
        <p class="text-brand-600 text-sm sm:text-base mb-5">Our team can design infrastructure tailored to your specific requirements.</p>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-red-500 hover:bg-brand-red-600 text-white text-sm font-medium rounded-full transition shadow-md">
            Contact Us <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>
@endsection
