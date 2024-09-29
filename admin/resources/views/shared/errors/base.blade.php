<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ Core::lang('ar') ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('shared.base.styles', ['type' => 'guest'])
    @yield('styles')
    <title>@yield('title')</title>
</head>

<body close class="bg-[#fcfcfc]">
    <section id="neo-page-cover">
        <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}" alt="{{ env('APP_NAME') }} logo image"
            class="block w-36" width="916" height="516" loading="lazy" />
    </section>
    <neo-wrapper class="flex flex-wrap">
        <main class="w-full p-4 container mx-auto flex flex-col gap-4 h-[100dvh]">
            <header class="w-full flex justify-center">
                <a href="{{ url('/') }}" class="block w-36 mx-auto" aria-label="home_page_link">
                    <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}"
                        alt="{{ env('APP_NAME') }} logo image" class="block w-full" width="916" height="516"
                        loading="lazy" />
                </a>
            </header>
            <section class="w-full flex flex-col gap-4 flex-1 items-center justify-center">
                @yield('content')
            </section>
        </main>
    </neo-wrapper>
    <neo-toaster horisontal="center" vertical="end"></neo-toaster>
    @include('shared.base.scripts', ['type' => 'guest'])
    @yield('scripts')
</body>

</html>
