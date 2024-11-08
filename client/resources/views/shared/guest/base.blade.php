<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ Core::lang('ar') ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('shared.base.styles', ['type' => 'admin'])
    @yield('styles')
    <title>@yield('title')</title>
</head>

<body close class="bg-x-light bg-x-gradient">
    <section id="neo-page-cover">
        <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}" alt="{{ env('APP_NAME') }} logo image"
            class="block w-36" width="916" height="516" loading="lazy" />
    </section>
    <neo-wrapper class="isolate">
        <neo-topbar transparent align="space-between" class="w-full">
            <a href="{{ route('views.guest.index') }}">
                <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} logo image" class="block w-24" width="916" height="516"
                    loading="lazy" />
            </a>
            <div class="w-max flex flex-wrap items-center gap-4">
                <a href="{{ route('views.login.index') }}"
                    class="block w-max px-4 py-2 rounded-x-thin bg-x-prime outline-none hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent text-x-white text-base font-x-thin pointer-events-auto">
                    {{ __('Login') }}
                </a>
                <neo-dropdown label="{{ __('Languages') }}" position="{{ Core::lang('ar') ? 'start' : 'end' }}"
                    class="pointer-events-auto">
                    <button slot="trigger" aria-label="language_trigger"
                        class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M610-196 568.513-90.019Q566-78 555.452-71q-10.548 7-23.606 7Q510-64 499.5-80.963 489-97.927 497-118.094L654.571-537.15Q658-549 668-556.5q10-7.5 22-7.5h31.552q11.821 0 21.672 7T758-538l164 419q6 20.462-5.6 37.73Q904.799-64 884.273-64q-14.692 0-26.733-7.76t-15.536-22.576L808.585-196H610Zm22-72h148l-73.054-202H705l-73 202ZM355.135-397l-179.34 178.842Q162.86-206 146.206-206.5q-16.654-.5-27.93-11Q107-229 108-246.689q1-17.69 11.654-28.321L303-458q-39.6-45.818-70.8-92.409Q201-597 179-646h90q16 34 38.329 64.567 22.328 30.566 48.274 63.433Q403-567 434.628-619.861 466.256-672.721 489-730H63.857q-17.753 0-29.305-12.289Q23-754.579 23-771.982q0-17.404 12.35-29.318 12.35-11.914 29.895-11.914h248.731v-41.893q0-17.529 11.748-29.211Q337.471-896 355.098-896t29.637 11.682q12.011 11.682 12.011 29.211v41.893h249.548q17.685 0 29.696 11.768Q688-789.679 688-771.895q0 17.509-12.282 29.702Q663.436-730 645.759-730h-74.975Q548-656 510-587.5T416-457l102 103-29.389 83.933L355.135-397Z" />
                        </svg>
                    </button>
                    <ul class="w-full flex flex-col">
                        <li class="w-full">
                            <a href="{{ route('actions.language.index', 'en') }}"
                                class="w-full flex flex-wrap gap-2 px-4 py-2 items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::lang('en') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                                <img src="{{ asset('lang/en.png') }}?v={{ env('APP_VERSION') }}" alt="english flag"
                                    class="block w-6 h-4 object-contain" />
                                <span class="block flex-1 text-base text-start">English</span>
                            </a>
                        </li>
                        <li class="w-full">
                            <a href="{{ route('actions.language.index', 'fr') }}"
                                class="w-full flex flex-wrap gap-2 px-4 py-2 items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::lang('fr') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                                <img src="{{ asset('lang/fr.png') }}?v={{ env('APP_VERSION') }}" alt="french flag"
                                    class="block w-6 h-4 object-contain" />
                                <span class="block flex-1 text-base text-start">Francais</span>
                            </a>
                        </li>
                        <li class="w-full">
                            <a href="{{ route('actions.language.index', 'ar') }}"
                                class="w-full flex flex-wrap gap-2 px-4 py-2 items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::lang('ar') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                                <img src="{{ asset('lang/ar.png') }}?v={{ env('APP_VERSION') }}" alt="arabic flag"
                                    class="block w-6 h-4 object-contain" />
                                <span class="block flex-1 text-base text-start">العربية</span>
                            </a>
                        </li>
                    </ul>
                </neo-dropdown>
            </div>
        </neo-topbar>
        <main class="flex flex-wrap">
            @yield('content')
        </main>
    </neo-wrapper>
    <neo-toaster horisontal="end" vertical="start"></neo-toaster>
    @include('shared.base.scripts', ['type' => 'admin'])
    @yield('scripts')
</body>

</html>
