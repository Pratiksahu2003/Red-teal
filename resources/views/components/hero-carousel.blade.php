@php
    $slidesData = $heroSlides->map(fn ($s) => [
        'category' => $s->category,
        'title' => $s->title,
        'description' => $s->description,
        'image' => $s->imageUrl(),
        'cta_text' => $s->cta_text,
        'cta_url' => $s->cta_url,
    ])->values();
@endphp

<section
    class="relative text-white min-h-[calc(100vh-4.5rem)] lg:min-h-[calc(100vh-5rem)] flex flex-col overflow-hidden -mt-px"
    x-data="heroCarousel(@js($slidesData))"
    @mouseenter="stopAutoplay()"
    @mouseleave="slides.length > 1 && startAutoplay()"
>
    {{-- Full-bleed background images --}}
    <div class="absolute inset-0 z-0">
        <template x-if="slides.length">
            <template x-for="(slide, index) in slides" :key="'bg-' + index">
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
                    :class="active === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                >
            </template>
        </template>
        {{-- Dark gradient overlay for text readability (left-heavy, like reference) --}}
        <div class="absolute inset-0 z-20 bg-gradient-to-r from-black/85 via-black/55 to-black/25"></div>
        <div class="absolute inset-0 z-20 bg-gradient-to-t from-black/70 via-transparent to-black/30"></div>
    </div>

    {{-- Hero content overlay --}}
    <div class="relative z-30 flex-1 flex items-center pt-8 lg:pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <template x-if="slides.length">
                <div class="max-w-2xl lg:max-w-3xl" :key="active">
                    <p
                        class="text-white/90 text-sm lg:text-base font-semibold mb-3 lg:mb-4"
                        x-text="current().category"
                        x-show="true"
                        x-transition:enter="transition ease-out duration-400"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    ></p>
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl xl:text-[3.4rem] font-bold leading-[1.08] mb-5 lg:mb-6 text-white"
                        x-text="current().title"
                        x-show="true"
                        x-transition:enter="transition ease-out duration-500 delay-75"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    ></h1>
                    <p
                        class="text-white/75 text-base lg:text-lg leading-relaxed mb-8 max-w-xl"
                        x-text="current().description"
                        x-show="true"
                        x-transition:enter="transition ease-out duration-500 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    ></p>
                    <template x-if="current().cta_text">
                        <a
                            :href="current().cta_url || '#'"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-brand-teal-500 hover:bg-brand-teal-400 text-brand-900 font-bold text-sm transition rounded-sm shadow-lg"
                            x-text="current().cta_text"
                            x-show="true"
                            x-transition:enter="transition ease-out duration-500 delay-150"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        ></a>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- Bottom tab navigation --}}
    <div class="relative z-30 border-t border-white/10 bg-black/60 backdrop-blur-sm" x-show="slides.length > 1">
        <div class="max-w-7xl mx-auto">
            <div class="flex overflow-x-auto scrollbar-hide">
                <template x-for="(slide, index) in slides" :key="'tab-' + index">
                    <button
                        type="button"
                        @click="goTo(index)"
                        class="relative flex-shrink-0 w-1/2 sm:w-1/3 lg:flex-1 min-w-[180px] text-left px-4 lg:px-5 py-4 lg:py-5 border-r border-white/10 last:border-r-0 group transition-colors hover:bg-white/5"
                        :class="active === index ? 'bg-white/5' : ''"
                    >
                        {{-- Progress bar --}}
                        <div class="absolute top-0 left-0 right-0 h-[3px] bg-white/10 overflow-hidden">
                            <div
                                class="h-full bg-brand-teal-500 transition-none"
                                :style="active === index ? `width: ${progress}%` : 'width: 0%'"
                            ></div>
                        </div>

                        <p
                            class="text-[11px] lg:text-xs font-medium mb-1.5 truncate transition-colors"
                            :class="active === index ? 'text-brand-teal-400' : 'text-white/45 group-hover:text-white/70'"
                            x-text="slide.category"
                        ></p>
                        <p
                            class="text-xs lg:text-sm leading-snug line-clamp-2 transition-colors"
                            :class="active === index ? 'text-white font-medium' : 'text-white/55 group-hover:text-white/80'"
                            x-text="slide.title"
                        ></p>
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>
