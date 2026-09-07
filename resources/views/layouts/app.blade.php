<!DOCTYPE html>
<html lang="{{ settings('website.default_language') ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#921a1d">
    <title>@yield('title', settings('website.default_page_title') ?? settings('company.company_name') ?? 'RedNTeal')</title>
    <meta name="description" content="@yield('meta_description', settings('website.default_meta_description') ?? '')">
    <meta name="keywords" content="{{ settings('website.default_keywords') ?? '' }}">
    <meta property="og:image" content="{{ settings('website.og_image') ? setting_url(settings('website.og_image')) : logo_url() }}">
    @include('components.favicon')
    @if(settings('website.google_tag_manager_id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ settings('website.google_tag_manager_id') }}');</script>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans bg-brand-50 text-brand-900 antialiased">
    @if(settings('website.google_tag_manager_id'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ settings('website.google_tag_manager_id') }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('components.navbar')

    <main>@yield('content')</main>

    @include('components.footer')

    <div x-data="{ show: !localStorage.getItem('cookie_accepted') }" x-show="show" x-cloak @show-cookie-notice.window="show = true" class="fixed bottom-4 left-4 right-4 md:left-auto md:right-6 md:max-w-md z-50">
        <div class="bg-brand-900 text-white p-5 rounded-2xl shadow-2xl flex flex-col gap-3 border border-brand-800">
            <p class="text-sm text-brand-200">We use cookies to improve your experience on our website.</p>
            <button @click="localStorage.setItem('cookie_accepted','1'); show=false" class="self-start px-4 py-2 bg-brand-teal-500 hover:bg-brand-teal-600 rounded-lg text-sm font-medium transition">Accept</button>
        </div>
    </div>
</body>
</html>
