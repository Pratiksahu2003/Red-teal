<?php

use App\Services\SiteSettingsService;

if (! function_exists('settings')) {
    function settings(?string $key = null, mixed $default = null): mixed
    {
        $service = app(SiteSettingsService::class);

        if ($key === null) {
            return $service->all();
        }

        return $service->get($key, $default);
    }
}

if (! function_exists('setting_url')) {
    function setting_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (! function_exists('logo_url')) {
    function logo_url(?string $variant = 'default'): ?string
    {
        $paths = [
            'default' => settings('branding.logo'),
            'dark' => settings('branding.logo_dark'),
            'light' => settings('branding.logo_light'),
            'footer' => settings('branding.footer_logo') ?? settings('branding.logo'),
        ];

        $path = $paths[$variant] ?? $paths['default'];

        if ($path) {
            if (str_starts_with($path, 'Logo/') || str_starts_with($path, 'images/')) {
                return asset($path);
            }

            return setting_url($path);
        }

        return asset('Logo/logo.png');
    }
}

if (! function_exists('favicon_url')) {
    function favicon_url(): string
    {
        $favicon = settings('branding.favicon');

        if (filled($favicon)) {
            if (str_starts_with($favicon, 'http')) {
                return $favicon;
            }

            if (str_starts_with($favicon, 'Logo/') || str_starts_with($favicon, 'images/')) {
                return asset($favicon);
            }

            $storageUrl = setting_url($favicon);
            if ($storageUrl) {
                return $storageUrl;
            }
        }

        return asset('favicon.ico');
    }
}

if (! function_exists('favicon_type')) {
    function favicon_type(): string
    {
        $path = strtolower(parse_url(favicon_url(), PHP_URL_PATH) ?? '');

        return str_ends_with($path, '.ico') ? 'image/x-icon' : 'image/png';
    }
}

if (! function_exists('hero_image_url')) {
    function hero_image_url(?string $path, string $fallback = 'images/hero-datacenter.jpg'): string
    {
        if (blank($path)) {
            return asset($fallback);
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, 'http')) {
            return str_starts_with($path, 'http') ? $path : asset($path);
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (! function_exists('rich_content')) {
    /**
     * Render CMS text: supports stored HTML or plain text with line breaks.
     */
    function rich_content(?string $content): string
    {
        if (blank($content)) {
            return '';
        }

        $content = trim($content);

        if (preg_match('/<[^>]+>/', $content)) {
            return strip_tags($content, '<p><br><strong><b><em><i><ul><ol><li><a><h2><h3><h4><blockquote><span><table><thead><tbody><tr><th><td>');
        }

        return nl2br(e($content));
    }
}

if (! function_exists('company_map_link')) {
    function company_map_link(): ?string
    {
        $link = settings('company.map_link');
        if (filled($link)) {
            return $link;
        }

        $parts = array_filter([
            settings('company.address'),
            settings('company.city'),
            settings('company.postal_code'),
            settings('company.country'),
        ]);

        if (empty($parts)) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode(implode(', ', $parts));
    }
}

if (! function_exists('company_map_embed_url')) {
    function company_map_embed_url(): ?string
    {
        $embed = settings('company.map_embed_url');
        if (filled($embed)) {
            return $embed;
        }

        $link = company_map_link();
        if (blank($link)) {
            return null;
        }

        if (str_contains($link, '/maps/embed')) {
            return $link;
        }

        if (str_contains($link, 'google.com/maps') || str_contains($link, 'maps.google.com')) {
            $separator = str_contains($link, '?') ? '&' : '?';

            return $link.$separator.'output=embed';
        }

        return 'https://www.google.com/maps?q='.urlencode($link).'&output=embed';
    }
}
