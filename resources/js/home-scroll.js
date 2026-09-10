import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

const APPLE_EASE = 'power3.out';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function revealFadeUp(elements, options = {}) {
    gsap.fromTo(
        elements,
        { autoAlpha: 0, y: options.distance ?? 56 },
        {
            autoAlpha: 1,
            y: 0,
            duration: options.duration ?? 1.05,
            ease: APPLE_EASE,
            stagger: options.stagger ?? 0,
            scrollTrigger: {
                trigger: options.trigger ?? elements,
                start: options.start ?? 'top 88%',
                toggleActions: 'play none none none',
            },
        },
    );
}

function revealScale(elements, options = {}) {
    gsap.fromTo(
        elements,
        { autoAlpha: 0, scale: options.fromScale ?? 0.94 },
        {
            autoAlpha: 1,
            scale: 1,
            duration: options.duration ?? 1.15,
            ease: APPLE_EASE,
            scrollTrigger: {
                trigger: options.trigger ?? elements,
                start: options.start ?? 'top 88%',
                toggleActions: 'play none none none',
            },
        },
    );
}

function initParallax(page) {
    page.querySelectorAll('[data-parallax]').forEach((el) => {
        const strength = parseFloat(el.dataset.parallax) || 14;

        gsap.fromTo(
            el,
            { yPercent: -strength * 0.35 },
            {
                yPercent: strength * 0.35,
                ease: 'none',
                scrollTrigger: {
                    trigger: el.closest('[data-parallax-wrap]') ?? el.parentElement,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.6,
                },
            },
        );
    });
}

function initStatCounters(page) {
    page.querySelectorAll('[data-stat-counter]').forEach((el) => {
        const raw = el.textContent.trim();
        const match = raw.match(/^([\d,.]+)(.*)$/);

        if (!match) {
            return;
        }

        const target = parseFloat(match[1].replace(/,/g, ''));
        const suffix = match[2] ?? '';
        const decimals = (match[1].split('.')[1] ?? '').length;
        const state = { value: 0 };

        gsap.to(state, {
            value: target,
            duration: 1.6,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el.closest('[data-reveal-child]') ?? el,
                start: 'top 90%',
                toggleActions: 'play none none none',
            },
            onUpdate: () => {
                el.textContent = `${state.value.toFixed(decimals)}${suffix}`;
            },
        });
    });
}

export function initHomeScrollAnimations() {
    const page = document.querySelector('[data-home-scroll]');

    if (!page || prefersReducedMotion()) {
        return;
    }

    page.querySelectorAll('[data-reveal="fade-up"]').forEach((el) => {
        revealFadeUp(el);
    });

    page.querySelectorAll('[data-reveal="scale"]').forEach((el) => {
        revealScale(el);
    });

    page.querySelectorAll('[data-reveal="stagger"]').forEach((container) => {
        const children = container.querySelectorAll('[data-reveal-child]');

        if (!children.length) {
            return;
        }

        revealFadeUp(children, {
            trigger: container,
            stagger: 0.1,
            distance: 44,
            duration: 0.95,
            start: 'top 86%',
        });
    });

    page.querySelectorAll('[data-reveal="split"]').forEach((section) => {
        const text = section.querySelector('[data-reveal-text]');
        const media = section.querySelector('[data-reveal-media]');

        if (text) {
            revealFadeUp(text, { trigger: section, distance: 48 });
        }

        if (media) {
            revealScale(media, { trigger: section, fromScale: 0.96 });
        }
    });

    initParallax(page);
    initStatCounters(page);

    ScrollTrigger.refresh();
}
