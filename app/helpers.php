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
            return setting_url($path);
        }

        return asset('Logo/logo.png');
    }
}

if (! function_exists('favicon_url')) {
    function favicon_url(): string
    {
        if ($favicon = settings('branding.favicon')) {
            return setting_url($favicon);
        }

        return asset('Logo/logo.png');
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
