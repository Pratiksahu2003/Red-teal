@extends('layouts.app')

@section('title', ($service->meta_title ?? $service->title) . ' — ' . (settings('company.company_name') ?? 'RedNTeal'))
@section('meta_description', $service->meta_description ?? $service->short_description)

@section('content')
@php
    $serviceHeroFallbacks = [
        'colocation' => 'images/hero-slide-1.jpg',
        'cloud-connectivity' => 'images/hero-slide-2.jpg',
        'managed-infrastructure' => 'images/hero-slide-5.jpg',
    ];
    $serviceHeroFallback = $serviceHeroFallbacks[$service->slug] ?? 'images/hero-datacenter.jpg';
@endphp
<x-page-hero
    :image="$service->featured_image"
    :fallback="$serviceHeroFallback"
    :alt="$service->title"
    size="lg"
>
    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-brand-300 hover:text-white text-sm mb-4 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> All Services
    </a>
    <div class="flex items-start gap-4">
        @if($service->icon)
            <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center shrink-0 border border-white/20">
                <i data-lucide="{{ $service->icon }}" class="w-7 h-7 text-brand-teal-300"></i>
            </div>
        @endif
        <div>
            @if($service->category)
                <p class="text-brand-teal-400 text-xs font-semibold uppercase tracking-wide mb-2">{{ $service->category }}</p>
            @endif
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-3 max-w-3xl">{{ $service->title }}</h1>
            <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">{{ $service->short_description }}</p>
        </div>
    </div>
</x-page-hero>

<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="prose-content text-brand-700 text-lg leading-relaxed">
                    {!! rich_content($service->full_description) !!}
                </div>
            </div>
            <div>
                <div class="bg-brand-100 rounded-2xl p-8 sticky top-28">
                    <h3 class="font-semibold text-brand-900 mb-4">Interested in this service?</h3>
                    <p class="text-brand-600 text-sm mb-6">Speak with our team about how {{ $service->title }} can support your infrastructure needs.</p>
                    <a href="{{ $service->cta_url ?? route('contact.index') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-brand-teal-600 hover:bg-brand-teal-500 text-white font-medium rounded-full transition">
                        {{ $service->cta_text ?? 'Get in Touch' }}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
