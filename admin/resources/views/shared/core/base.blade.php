<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ Core::lang('ar') ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('meta')
    @include('shared.base.styles', ['type' => 'admin'])
    @yield('styles')
    <title>@yield('title')</title>
    @if (Core::setting())
        <meta name="core"
            content="{{ json_encode([
                'format' => Core::formatsList(Core::setting('date_format'), 0),
                'currency' => Core::setting('currency'),
            ]) }}">
        @php
            $colors = Core::themesList(Core::setting('theme_color'));
            \Carbon\Carbon::setLocale(Core::setting('language'));
        @endphp
        <style>
            *,
            :root,
            *::after,
            *::before {
                --prime: {{ $colors[0] }};
                --acent: {{ $colors[1] }};
            }
        </style>
    @endif
</head>

<body close class="bg-x-light">
    <section id="neo-page-cover">
        <img src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}"
            alt="{{ env('APP_NAME') }} logo image" class="block w-36" width="916" height="516" />
    </section>
    <neo-wrapper class="flex flex-wrap">
        @include('shared.core.sidebar')
        <main class="w-full lg:w-0 lg:flex-1">
            @include('shared.core.topbar')
            <div class="p-4 py-8 md:pt-0 container mx-auto">
                @yield('content')
            </div>
        </main>
    </neo-wrapper>
    <neo-toaster horisontal="end" vertical="start" class="full-size"></neo-toaster>
    @include('shared.base.scripts', ['type' => 'admin'])
    @yield('scripts')
</body>

</html>
