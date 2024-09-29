<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ Core::lang('ar') ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('shared.base.styles', ['type' => 'admin'])
    {{-- @yield('styles')
    <title>@yield('title')</title> --}}
</head>

<body close class="bg-x-white">
    <section id="neo-page-cover">
        <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}" alt="{{ env('APP_NAME') }} logo image"
            class="block w-36" width="916" height="516" loading="lazy" />
    </section>
    <neo-wrapper class="isolate">
        <header class="flex flex-col gap-8">
            <neo-topbar transparent align="space-between" class="w-full">
                <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} logo image" class="block w-24" width="916" height="516"
                    loading="lazy" />
                <div class="w-max flex flex-wrap items-center gap-4">
                    <a href="{{ route('views.companies.store') }}"
                        class="block w-max px-4 py-2 rounded-x-thin bg-x-prime outline-none hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent text-x-white text-base font-x-thin pointer-events-auto">
                        {{ __('Subscribe') }}
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
                                    <img src="{{ asset('lang/en.png') }}?v={{ env('APP_VERSION') }}"
                                        alt="english flag" class="block w-6 h-4 object-contain" />
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
            <div class="w-full p-4 container mx-auto flex flex-wrap relative isolate">
                <img src="{{ asset('img/pattern.png') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} pattern image"
                    class="block w-full absolute left-0 right-0 top-1/2 -translate-y-[70%] z-[-200] opacity-50 pointer-events-none"
                    loading="lazy" />
                <div class="w-full lg:w-10/12 mx-auto flex flex-col gap-6 lg:gap-10">
                    <div class="w-full flex flex-col gap-2 lg:gap-4 lg:px-10">
                        <h1 class="font-x-huge text-center text-x-black text-2xl lg:text-5xl">
                            {{ ucwords(__('revolutionize your car rental business with our all-in-one solution')) }}
                        </h1>
                        <h2 class="text-center text-x-black text-lg lg:text-2xl">
                            {{ ucfirst(__('enhance your business operations, increase profits, and deliver better customer experiences')) }}
                        </h2>
                        <div class="flex items-center justify-center gap-4 mt-2">
                            <a href="{{ route('views.companies.store') }}"
                                class="block w-max px-4 py-2 lg:px-10 lg:py-4 rounded-x-thin bg-x-prime outline-none hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent text-x-white text-base lg:text-2xl font-x-thin pointer-events-auto">
                                {{ __('Subscribe') }}
                            </a>
                            <a href="{{ route('views.login.index') }}"
                                class="block w-max px-4 py-2 lg:px-10 lg:py-3 rounded-x-thin border-2 border-x-prime outline-none text-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent hover:text-x-white focus:text-x-white focus-within:text-x-white hover:border-x-acent focus:border-x-acent focus-within:border-x-acent text-base lg:text-2xl font-x-thin pointer-events-auto">
                                {{ __('Login') }}
                            </a>
                        </div>
                    </div>
                    <div class="w-full rounded-x-huge relative isolate">
                        <div
                            class="w-full h-full overflow-hidden rounded-x-huge absolute inset-0 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 z-[-100]">
                            <div class="w-[140%] h-48 relative top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
                                <div class="w-full h-full bg-x-prime animate-spin" style="animation-duration: 5s">
                                </div>
                            </div>
                        </div>
                        <div class="p-1">
                            <img src="{{ asset('img/poster.png') }}?v={{ env('APP_VERSION') }}"
                                alt="{{ env('APP_NAME') }} poster image"
                                class="block bg-x-shade w-full shadow-x-core rounded-x-huge" width="916"
                                height="516" loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="w-full flex flex-col mt-10 lg:mt-16 gap-10">
            <section class="2xl:container mx-auto w-full relative">
                <svg class="block w-full absolute inset-0 top-1/2 -translate-y-[40%] pointer-events-none z-[-100] blur-sm"
                    viewBox="0 0 1422 800">
                    <defs>
                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%"
                            id="oooscillate-grad">
                            <stop stop-color="rgb(33 150 243)" stop-opacity="1" offset="0%"></stop>
                            <stop stop-color="rgb(110 185 247)" stop-opacity="1" offset="100%"></stop>
                        </linearGradient>
                    </defs>
                    <g stroke-width="1" stroke="url(#oooscillate-grad)" fill="none" stroke-linecap="round">
                        <path d="M 0 665 Q 355.5 -100 711 400 Q 1066.5 900 1422 665" opacity="0.05"></path>
                        <path d="M 0 646 Q 355.5 -100 711 400 Q 1066.5 900 1422 646" opacity="0.08"></path>
                        <path d="M 0 627 Q 355.5></path>
                        <path d=" M 0 608 Q 355.5></path>
                        <path d="M 0 589 Q 355.5></path>
                        <path d=" M 0 570 Q 355.5></path>
                        <path d="M 0 551 Q 355.5></path>
                        <path d=" M 0 532 Q 355.5></path>
                        <path d="M 0 513 Q 355.5></path>
                        <path d=" M 0 494 Q 355.5></path>
                        <path d="M 0 475 Q 355.5></path>
                        <path d=" M 0 456 Q 355.5></path>
                        <path d="M 0 437 Q 355.5></path>
                        <path d=" M 0 418 Q 355></path>
                        <path d="M 0 399 Q 355></path>
                        <path d=" M 0 380 Q 355></path>
                        <path d="M 0 361 Q 355.5 -100 711 400 Q 1066.5 900 1422 361" opacity="0.50"></path>
                        <path d="M 0 342 Q 355.5 -100 711 400 Q 1066.5 900 1422 342" opacity="0.53"></path>
                        <path d="M 0 323 Q 355.5 -100 711 400 Q 1066.5 900 1422 323" opacity="0.55"></path>
                        <path d="M 0 304 Q 355.5 -100 711 400 Q 1066.5 900 1422 304" opacity="0.58"></path>
                        <path d="M 0 285 Q 355.5 -100 711 400 Q 1066.5 900 1422 285" opacity="0.61"></path>
                        <path d="M 0 266 Q 355.5 -100 711 400 Q 1066.5 900 1422 266" opacity="0.64"></path>
                        <path d="M 0 247 Q 355.5 -100 711 400 Q 1066.5 900 1422 247" opacity="0.66"></path>
                        <path d="M 0 228 Q 355.5 -100 711 400 Q 1066.5 900 1422 228" opacity="0.69"></path>
                        <path d="M 0 209 Q 355.5 -100 711 400 Q 1066.5 900 1422 209" opacity="0.72"></path>
                        <path d="M 0 190 Q 355.5 -100 711 400 Q 1066.5 900 1422 190" opacity="0.75"></path>
                        <path d="M 0 171 Q 355.5 -100 711 400 Q 1066.5 900 1422 171" opacity="0.78"></path>
                        <path d="M 0 152 Q 355.5 -100 711 400 Q 1066.5 900 1422 152" opacity="0.80"></path>
                        <path d="M 0 133 Q 355.5 -100 711 400 Q 1066.5 900 1422 133" opacity="0.83"></path>
                        <path d="M 0 114 Q 355.5 -100 711 400 Q 1066.5 900 1422 114" opacity="0.86"></path>
                        <path d="M 0 95 Q 355.5 -100 711 400 Q 1066.5 900 1422 95" opacity="0.89"></path>
                        <path d="M 0 76 Q 355.5 -100 711 400 Q 1066.5 900 1422 76" opacity="0.92"></path>
                        <path d="M 0 57 Q 355.5 -100 711 400 Q 1066.5 900 1422 57" opacity="0.94"></path>
                        <path d="M 0 38 Q 355.5 -100 711 400 Q 1066.5 900 1422 38" opacity="0.97"></path>
                    </g>
                </svg>
                <div class="p-4 container mx-auto flex flex-col gap-10">
                    <div class="flex flex-col gap-3">
                        <h3 class="font-x-thin text-center text-x-black text-xl lg:text-3xl">
                            {{ ucwords(__('why we’re the best choice for your car rental business')) }}
                        </h3>
                        <p class="text-center text-x-black text-base lg:text-xl">
                            {{ ucfirst(__('discover the benefits of choosing a solution that’s tailored to your car rental business needs')) }}
                        </p>
                    </div>
                    <ul class="grid grid-rows-1 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            $bollets = [
                                'all-in-one management' =>
                                    'centralize your fleet, reservations, and customer interactions in a single, streamlined platform',
                                'intuitive interface' =>
                                    'enjoy a user-friendly experience designed to make managing your business easy and efficient',
                                'scalable solutions' =>
                                    'adapt and expand with flexible features and plans that grow with your business needs',
                                'advanced analytics' =>
                                    'utilize advanced reporting tools to gain insights and drive data-driven decisions',
                                'robust security' =>
                                    'safeguard your business and customer data with our top-tier security and reliable infrastructure',
                                '24/7 customer support' =>
                                    'get 24/7 assistance from our dedicated support team for prompt issue resolution',
                            ];
                        @endphp
                        @foreach ($bollets as $head => $text)
                            <li
                                class="flex flex-wrap gap-2 items-start border border-x-light bg-x-light bg-opacity-20 rounded-x-huge p-6">
                                <div class="flex flex-col gap-1">
                                    <div class="bg-x-prime mx-auto rounded-x-thin w-14 h-14 mb-2"></div>
                                    <h5 class="font-x-thin text-x-black text-center text-lg lg:text-xl">
                                        {{ ucwords(__($head)) }}
                                    </h5>
                                    <p class="text-x-black text-center text-base">
                                        {{ ucfirst(__($text)) }}.
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <section class="p-4 container mx-auto grid grid-rows-1 grid-cols-1 lg:grid-cols-5 items-start gap-6">
                <div class="flex flex-col gap-5 lg:col-span-2">
                    <div class="flex flex-col gap-3">
                        <h3 class="font-x-thin text-start text-x-black text-xl lg:text-3xl">
                            {{ ucwords(__('FAQ')) }}
                        </h3>
                        <p class="text-start text-x-black text-base lg:text-xl">
                            {{ ucfirst(__('below you\'ll find answers to the most common questions about our services and how they can benefit your car rental business. If you don’t see your question here, feel free to contact our support team for further assistance')) }}
                        </p>
                    </div>
                    <a href="{{ route('views.login.index') }}"
                        class="block w-max px-4 py-2 rounded-x-thin border border-x-prime outline-none text-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent hover:text-x-white focus:text-x-white focus-within:text-x-white hover:border-x-acent focus:border-x-acent focus-within:border-x-acent text-base font-x-thin pointer-events-auto">
                        {{ __('Read more') }}
                    </a>
                </div>
                <ul class="flex flex-col gap-2 lg:col-span-3">
                    @for ($i = 0; $i < 4; $i++)
                        <li
                            class="tab-main tab-open w-full rounded-x-huge border bg-opacity-20 {{ $i === 0 ? 'border-x-prime bg-x-prime' : 'border-x-light bg-x-light' }}">
                            <div class="tab-header px-6 py-3 cursor-pointer flex flex-wrap gap-4 items-center">
                                <h5 class="w-0 flex-1 text-x-black text-lg lg:text-xl">
                                    Hello there
                                </h5>
                                <div class="bg-x-black rounded-x-thin w-6 h-6"></div>
                            </div>
                            <div class="tab-content overflow-hidden transition-all duration-150"
                                style="max-height: {{ $i === 0 ? '500px' : '0px' }}">
                                <p class="text-x-black text-base p-6 border-t border-x-prime">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam in hic nobis nulla.
                                    Ea, officiis nam quas similique porro ipsam voluptas provident modi, voluptatum
                                    suscipit quae? Reiciendis architecto vitae provident doloribus quis eius, harum
                                    libero corrupti nihil nesciunt quidem voluptatum voluptates eum dolores consequuntur
                                    dolor ut obcaecati quo temporibus iste!
                                </p>
                            </div>
                        </li>
                    @endfor
                </ul>
            </section>
            <section class="p-4 container mx-auto">
                <div
                    class="flex flex-col gap-10 px-6 py-10 relative isolate rounded-x-huge overflow-hidden border-2 border-x-prime border-opacity-50">
                    <svg class="block w-[200%] md:w-full absolute inset-0 top-1/2 -translate-y-1/2 pointer-events-none z-[-100]"
                        viewBox="0 0 1422 800">
                        <g class="text-x- text-opacity-50" stroke-width="6" stroke="currentColor" fill="none"
                            stroke-linecap="round">
                            <line x1="54" y1="0" x2="0" y2="54"></line>
                            <line x1="108" y1="0" x2="54" y2="54"></line>
                            <line x1="108" y1="0" x2="162" y2="54"></line>
                            <line x1="216" y1="0" x2="162" y2="54"></line>
                            <line x1="216" y1="0" x2="270" y2="54"></line>
                            <line x1="270" y1="0" x2="324" y2="54"></line>
                            <line x1="324" y1="0" x2="378" y2="54"></line>
                            <line x1="378" y1="0" x2="432" y2="54"></line>
                            <line x1="486" y1="0" x2="432" y2="54"></line>
                            <line x1="540" y1="0" x2="486" y2="54"></line>
                            <line x1="594" y1="0" x2="540" y2="54"></line>
                            <line x1="648" y1="0" x2="594" y2="54"></line>
                            <line x1="702" y1="0" x2="648" y2="54"></line>
                            <line x1="702" y1="0" x2="756" y2="54"></line>
                            <line x1="810" y1="0" x2="756" y2="54"></line>
                            <line x1="864" y1="0" x2="810" y2="54"></line>
                            <line x1="864" y1="0" x2="918" y2="54"></line>
                            <line x1="918" y1="0" x2="972" y2="54"></line>
                            <line x1="1026" y1="0" x2="972" y2="54"></line>
                            <line x1="1026" y1="0" x2="1080" y2="54"></line>
                            <line x1="1080" y1="0" x2="1134" y2="54"></line>
                            <line x1="1188" y1="0" x2="1134" y2="54"></line>
                            <line x1="1242" y1="0" x2="1188" y2="54"></line>
                            <line x1="1296" y1="0" x2="1242" y2="54"></line>
                            <line x1="1350" y1="0" x2="1296" y2="54"></line>
                            <line x1="1350" y1="0" x2="1404" y2="54"></line>
                            <line x1="1404" y1="0" x2="1458" y2="54"></line>
                            <line x1="0" y1="54" x2="54" y2="108"></line>
                            <line x1="108" y1="54" x2="54" y2="108"></line>
                            <line x1="162" y1="54" x2="108" y2="108"></line>
                            <line x1="162" y1="54" x2="216" y2="108"></line>
                            <line x1="216" y1="54" x2="270" y2="108"></line>
                            <line x1="324" y1="54" x2="270" y2="108"></line>
                            <line x1="378" y1="54" x2="324" y2="108"></line>
                            <line x1="378" y1="54" x2="432" y2="108"></line>
                            <line x1="432" y1="54" x2="486" y2="108"></line>
                            <line x1="540" y1="54" x2="486" y2="108"></line>
                            <line x1="594" y1="54" x2="540" y2="108"></line>
                            <line x1="594" y1="54" x2="648" y2="108"></line>
                            <line x1="702" y1="54" x2="648" y2="108"></line>
                            <line x1="702" y1="54" x2="756" y2="108"></line>
                            <line x1="810" y1="54" x2="756" y2="108"></line>
                            <line x1="810" y1="54" x2="864" y2="108"></line>
                            <line x1="918" y1="54" x2="864" y2="108"></line>
                            <line x1="972" y1="54" x2="918" y2="108"></line>
                            <line x1="972" y1="54" x2="1026" y2="108"></line>
                            <line x1="1026" y1="54" x2="1080" y2="108"></line>
                            <line x1="1134" y1="54" x2="1080" y2="108"></line>
                            <line x1="1188" y1="54" x2="1134" y2="108"></line>
                            <line x1="1242" y1="54" x2="1188" y2="108"></line>
                            <line x1="1242" y1="54" x2="1296" y2="108"></line>
                            <line x1="1296" y1="54" x2="1350" y2="108"></line>
                            <line x1="1350" y1="54" x2="1404" y2="108"></line>
                            <line x1="1458" y1="54" x2="1404" y2="108"></line>
                            <line x1="54" y1="108" x2="0" y2="162"></line>
                            <line x1="108" y1="108" x2="54" y2="162"></line>
                            <line x1="162" y1="108" x2="108" y2="162"></line>
                            <line x1="216" y1="108" x2="162" y2="162"></line>
                            <line x1="270" y1="108" x2="216" y2="162"></line>
                            <line x1="270" y1="108" x2="324" y2="162"></line>
                            <line x1="378" y1="108" x2="324" y2="162"></line>
                            <line x1="432" y1="108" x2="378" y2="162"></line>
                            <line x1="486" y1="108" x2="432" y2="162"></line>
                            <line x1="540" y1="108" x2="486" y2="162"></line>
                            <line x1="594" y1="108" x2="540" y2="162"></line>
                            <line x1="594" y1="108" x2="648" y2="162"></line>
                            <line x1="702" y1="108" x2="648" y2="162"></line>
                            <line x1="702" y1="108" x2="756" y2="162"></line>
                            <line x1="756" y1="108" x2="810" y2="162"></line>
                            <line x1="810" y1="108" x2="864" y2="162"></line>
                            <line x1="864" y1="108" x2="918" y2="162"></line>
                            <line x1="972" y1="108" x2="918" y2="162"></line>
                            <line x1="1026" y1="108" x2="972" y2="162"></line>
                            <line x1="1080" y1="108" x2="1026" y2="162"></line>
                            <line x1="1134" y1="108" x2="1080" y2="162"></line>
                            <line x1="1188" y1="108" x2="1134" y2="162"></line>
                            <line x1="1242" y1="108" x2="1188" y2="162"></line>
                            <line x1="1296" y1="108" x2="1242" y2="162"></line>
                            <line x1="1296" y1="108" x2="1350" y2="162"></line>
                            <line x1="1350" y1="108" x2="1404" y2="162"></line>
                            <line x1="1404" y1="108" x2="1458" y2="162"></line>
                            <line x1="54" y1="162" x2="0" y2="216"></line>
                            <line x1="54" y1="162" x2="108" y2="216"></line>
                            <line x1="162" y1="162" x2="108" y2="216"></line>
                            <line x1="162" y1="162" x2="216" y2="216"></line>
                            <line x1="270" y1="162" x2="216" y2="216"></line>
                            <line x1="270" y1="162" x2="324" y2="216"></line>
                            <line x1="378" y1="162" x2="324" y2="216"></line>
                            <line x1="432" y1="162" x2="378" y2="216"></line>
                            <line x1="486" y1="162" x2="432" y2="216"></line>
                            <line x1="540" y1="162" x2="486" y2="216"></line>
                            <line x1="540" y1="162" x2="594" y2="216"></line>
                            <line x1="648" y1="162" x2="594" y2="216"></line>
                            <line x1="702" y1="162" x2="648" y2="216"></line>
                            <line x1="702" y1="162" x2="756" y2="216"></line>
                            <line x1="810" y1="162" x2="756" y2="216"></line>
                            <line x1="810" y1="162" x2="864" y2="216"></line>
                            <line x1="918" y1="162" x2="864" y2="216"></line>
                            <line x1="972" y1="162" x2="918" y2="216"></line>
                            <line x1="1026" y1="162" x2="972" y2="216"></line>
                            <line x1="1026" y1="162" x2="1080" y2="216"></line>
                            <line x1="1134" y1="162" x2="1080" y2="216"></line>
                            <line x1="1134" y1="162" x2="1188" y2="216"></line>
                            <line x1="1188" y1="162" x2="1242" y2="216"></line>
                            <line x1="1296" y1="162" x2="1242" y2="216"></line>
                            <line x1="1350" y1="162" x2="1296" y2="216"></line>
                            <line x1="1350" y1="162" x2="1404" y2="216"></line>
                            <line x1="1458" y1="162" x2="1404" y2="216"></line>
                            <line x1="54" y1="216" x2="0" y2="270"></line>
                            <line x1="108" y1="216" x2="54" y2="270"></line>
                            <line x1="108" y1="216" x2="162" y2="270"></line>
                            <line x1="216" y1="216" x2="162" y2="270"></line>
                            <line x1="216" y1="216" x2="270" y2="270"></line>
                            <line x1="270" y1="216" x2="324" y2="270"></line>
                            <line x1="324" y1="216" x2="378" y2="270"></line>
                            <line x1="378" y1="216" x2="432" y2="270"></line>
                            <line x1="486" y1="216" x2="432" y2="270"></line>
                            <line x1="486" y1="216" x2="540" y2="270"></line>
                            <line x1="594" y1="216" x2="540" y2="270"></line>
                            <line x1="648" y1="216" x2="594" y2="270"></line>
                            <line x1="648" y1="216" x2="702" y2="270"></line>
                            <line x1="702" y1="216" x2="756" y2="270"></line>
                            <line x1="810" y1="216" x2="756" y2="270"></line>
                            <line x1="864" y1="216" x2="810" y2="270"></line>
                            <line x1="864" y1="216" x2="918" y2="270"></line>
                            <line x1="972" y1="216" x2="918" y2="270"></line>
                            <line x1="1026" y1="216" x2="972" y2="270"></line>
                            <line x1="1080" y1="216" x2="1026" y2="270"></line>
                            <line x1="1134" y1="216" x2="1080" y2="270"></line>
                            <line x1="1188" y1="216" x2="1134" y2="270"></line>
                            <line x1="1242" y1="216" x2="1188" y2="270"></line>
                            <line x1="1296" y1="216" x2="1242" y2="270"></line>
                            <line x1="1350" y1="216" x2="1296" y2="270"></line>
                            <line x1="1404" y1="216" x2="1350" y2="270"></line>
                            <line x1="1458" y1="216" x2="1404" y2="270"></line>
                            <line x1="54" y1="270" x2="0" y2="324"></line>
                            <line x1="108" y1="270" x2="54" y2="324"></line>
                            <line x1="162" y1="270" x2="108" y2="324"></line>
                            <line x1="162" y1="270" x2="216" y2="324"></line>
                            <line x1="216" y1="270" x2="270" y2="324"></line>
                            <line x1="324" y1="270" x2="270" y2="324"></line>
                            <line x1="378" y1="270" x2="324" y2="324"></line>
                            <line x1="378" y1="270" x2="432" y2="324"></line>
                            <line x1="432" y1="270" x2="486" y2="324"></line>
                            <line x1="486" y1="270" x2="540" y2="324"></line>
                            <line x1="594" y1="270" x2="540" y2="324"></line>
                            <line x1="648" y1="270" x2="594" y2="324"></line>
                            <line x1="702" y1="270" x2="648" y2="324"></line>
                            <line x1="756" y1="270" x2="702" y2="324"></line>
                            <line x1="756" y1="270" x2="810" y2="324"></line>
                            <line x1="864" y1="270" x2="810" y2="324"></line>
                            <line x1="864" y1="270" x2="918" y2="324"></line>
                            <line x1="972" y1="270" x2="918" y2="324"></line>
                            <line x1="1026" y1="270" x2="972" y2="324"></line>
                            <line x1="1026" y1="270" x2="1080" y2="324"></line>
                            <line x1="1080" y1="270" x2="1134" y2="324"></line>
                            <line x1="1188" y1="270" x2="1134" y2="324"></line>
                            <line x1="1242" y1="270" x2="1188" y2="324"></line>
                            <line x1="1242" y1="270" x2="1296" y2="324"></line>
                            <line x1="1296" y1="270" x2="1350" y2="324"></line>
                            <line x1="1404" y1="270" x2="1350" y2="324"></line>
                            <line x1="1458" y1="270" x2="1404" y2="324"></line>
                            <line x1="54" y1="324" x2="0" y2="378"></line>
                            <line x1="108" y1="324" x2="54" y2="378"></line>
                            <line x1="162" y1="324" x2="108" y2="378"></line>
                            <line x1="162" y1="324" x2="216" y2="378"></line>
                            <line x1="216" y1="324" x2="270" y2="378"></line>
                            <line x1="270" y1="324" x2="324" y2="378"></line>
                            <line x1="324" y1="324" x2="378" y2="378"></line>
                            <line x1="378" y1="324" x2="432" y2="378">
                            </line>
                            <line x1="432" y1="324" x2="486" y2="378">
                            </line>
                            <line x1="540" y1="324" x2="486" y2="378">
                            </line>
                            <line x1="540" y1="324" x2="594" y2="378">
                            </line>
                            <line x1="594" y1="324" x2="648" y2="378">
                            </line>
                            <line x1="702" y1="324" x2="648" y2="378">
                            </line>
                            <line x1="756" y1="324" x2="702" y2="378">
                            </line>
                            <line x1="810" y1="324" x2="756" y2="378">
                            </line>
                            <line x1="810" y1="324" x2="864" y2="378">
                            </line>
                            <line x1="864" y1="324" x2="918" y2="378">
                            </line>
                            <line x1="918" y1="324" x2="972" y2="378">
                            </line>
                            <line x1="1026" y1="324" x2="972" y2="378">
                            </line>
                            <line x1="1080" y1="324" x2="1026" y2="378">
                            </line>
                            <line x1="1134" y1="324" x2="1080" y2="378">
                            </line>
                            <line x1="1134" y1="324" x2="1188" y2="378">
                            </line>
                            <line x1="1188" y1="324" x2="1242" y2="378">
                            </line>
                            <line x1="1242" y1="324" x2="1296" y2="378">
                            </line>
                            <line x1="1350" y1="324" x2="1296" y2="378">
                            </line>
                            <line x1="1404" y1="324" x2="1350" y2="378">
                            </line>
                            <line x1="1404" y1="324" x2="1458" y2="378">
                            </line>
                            <line x1="54" y1="378" x2="0" y2="432">
                            </line>
                            <line x1="54" y1="378" x2="108" y2="432">
                            </line>
                            <line x1="162" y1="378" x2="108" y2="432">
                            </line>
                            <line x1="216" y1="378" x2="162" y2="432">
                            </line>
                            <line x1="216" y1="378" x2="270" y2="432">
                            </line>
                            <line x1="270" y1="378" x2="324" y2="432">
                            </line>
                            <line x1="378" y1="378" x2="324" y2="432">
                            </line>
                            <line x1="378" y1="378" x2="432" y2="432">
                            </line>
                            <line x1="432" y1="378" x2="486" y2="432">
                            </line>
                            <line x1="540" y1="378" x2="486" y2="432">
                            </line>
                            <line x1="540" y1="378" x2="594" y2="432">
                            </line>
                            <line x1="648" y1="378" x2="594" y2="432">
                            </line>
                            <line x1="702" y1="378" x2="648" y2="432">
                            </line>
                            <line x1="756" y1="378" x2="702" y2="432">
                            </line>
                            <line x1="810" y1="378" x2="756" y2="432">
                            </line>
                            <line x1="810" y1="378" x2="864" y2="432">
                            </line>
                            <line x1="864" y1="378" x2="918" y2="432">
                            </line>
                            <line x1="918" y1="378" x2="972" y2="432">
                            </line>
                            <line x1="972" y1="378" x2="1026" y2="432">
                            </line>
                            <line x1="1026" y1="378" x2="1080" y2="432">
                            </line>
                            <line x1="1134" y1="378" x2="1080" y2="432">
                            </line>
                            <line x1="1134" y1="378" x2="1188" y2="432">
                            </line>
                            <line x1="1188" y1="378" x2="1242" y2="432">
                            </line>
                            <line x1="1296" y1="378" x2="1242" y2="432">
                            </line>
                            <line x1="1350" y1="378" x2="1296" y2="432">
                            </line>
                            <line x1="1404" y1="378" x2="1350" y2="432">
                            </line>
                            <line x1="1458" y1="378" x2="1404" y2="432">
                            </line>
                            <line x1="0" y1="432" x2="54" y2="486">
                            </line>
                            <line x1="54" y1="432" x2="108" y2="486">
                            </line>
                            <line x1="108" y1="432" x2="162" y2="486">
                            </line>
                            <line x1="162" y1="432" x2="216" y2="486">
                            </line>
                            <line x1="270" y1="432" x2="216" y2="486">
                            </line>
                            <line x1="270" y1="432" x2="324" y2="486">
                            </line>
                            <line x1="378" y1="432" x2="324" y2="486">
                            </line>
                            <line x1="432" y1="432" x2="378" y2="486">
                            </line>
                            <line x1="432" y1="432" x2="486" y2="486">
                            </line>
                            <line x1="540" y1="432" x2="486" y2="486">
                            </line>
                            <line x1="540" y1="432" x2="594" y2="486">
                            </line>
                            <line x1="594" y1="432" x2="648" y2="486">
                            </line>
                            <line x1="648" y1="432" x2="702" y2="486">
                            </line>
                            <line x1="702" y1="432" x2="756" y2="486">
                            </line>
                            <line x1="756" y1="432" x2="810" y2="486">
                            </line>
                            <line x1="864" y1="432" x2="810" y2="486">
                            </line>
                            <line x1="864" y1="432" x2="918" y2="486">
                            </line>
                            <line x1="972" y1="432" x2="918" y2="486">
                            </line>
                            <line x1="1026" y1="432" x2="972" y2="486">
                            </line>
                            <line x1="1026" y1="432" x2="1080" y2="486">
                            </line>
                            <line x1="1080" y1="432" x2="1134" y2="486">
                            </line>
                            <line x1="1188" y1="432" x2="1134" y2="486">
                            </line>
                            <line x1="1242" y1="432" x2="1188" y2="486">
                            </line>
                            <line x1="1296" y1="432" x2="1242" y2="486">
                            </line>
                            <line x1="1296" y1="432" x2="1350" y2="486">
                            </line>
                            <line x1="1350" y1="432" x2="1404" y2="486">
                            </line>
                            <line x1="1458" y1="432" x2="1404" y2="486">
                            </line>
                            <line x1="54" y1="486" x2="0" y2="540">
                            </line>
                            <line x1="108" y1="486" x2="54" y2="540">
                            </line>
                            <line x1="162" y1="486" x2="108" y2="540">
                            </line>
                            <line x1="162" y1="486" x2="216" y2="540">
                            </line>
                            <line x1="270" y1="486" x2="216" y2="540">
                            </line>
                            <line x1="270" y1="486" x2="324" y2="540">
                            </line>
                            <line x1="324" y1="486" x2="378" y2="540">
                            </line>
                            <line x1="432" y1="486" x2="378" y2="540">
                            </line>
                            <line x1="432" y1="486" x2="486" y2="540">
                            </line>
                            <line x1="540" y1="486" x2="486" y2="540">
                            </line>
                            <line x1="540" y1="486" x2="594" y2="540">
                            </line>
                            <line x1="648" y1="486" x2="594" y2="540">
                            </line>
                            <line x1="648" y1="486" x2="702" y2="540">
                            </line>
                            <line x1="702" y1="486" x2="756" y2="540">
                            </line>
                            <line x1="810" y1="486" x2="756" y2="540">
                            </line>
                            <line x1="864" y1="486" x2="810" y2="540">
                            </line>
                            <line x1="918" y1="486" x2="864" y2="540">
                            </line>
                            <line x1="918" y1="486" x2="972" y2="540">
                            </line>
                            <line x1="1026" y1="486" x2="972" y2="540">
                            </line>
                            <line x1="1026" y1="486" x2="1080" y2="540">
                            </line>
                            <line x1="1134" y1="486" x2="1080" y2="540">
                            </line>
                            <line x1="1188" y1="486" x2="1134" y2="540">
                            </line>
                            <line x1="1188" y1="486" x2="1242" y2="540">
                            </line>
                            <line x1="1296" y1="486" x2="1242" y2="540">
                            </line>
                            <line x1="1296" y1="486" x2="1350" y2="540">
                            </line>
                            <line x1="1404" y1="486" x2="1350" y2="540">
                            </line>
                            <line x1="1458" y1="486" x2="1404" y2="540">
                            </line>
                            <line x1="0" y1="540" x2="54" y2="594">
                            </line>
                            <line x1="108" y1="540" x2="54" y2="594">
                            </line>
                            <line x1="162" y1="540" x2="108" y2="594">
                            </line>
                            <line x1="216" y1="540" x2="162" y2="594">
                            </line>
                            <line x1="216" y1="540" x2="270" y2="594">
                            </line>
                            <line x1="270" y1="540" x2="324" y2="594">
                            </line>
                            <line x1="378" y1="540" x2="324" y2="594">
                            </line>
                            <line x1="432" y1="540" x2="378" y2="594">
                            </line>
                            <line x1="432" y1="540" x2="486" y2="594">
                            </line>
                            <line x1="540" y1="540" x2="486" y2="594">
                            </line>
                            <line x1="594" y1="540" x2="540" y2="594">
                            </line>
                            <line x1="594" y1="540" x2="648" y2="594">
                            </line>
                            <line x1="702" y1="540" x2="648" y2="594">
                            </line>
                            <line x1="756" y1="540" x2="702" y2="594">
                            </line>
                            <line x1="756" y1="540" x2="810" y2="594">
                            </line>
                            <line x1="864" y1="540" x2="810" y2="594">
                            </line>
                            <line x1="918" y1="540" x2="864" y2="594">
                            </line>
                            <line x1="972" y1="540" x2="918" y2="594">
                            </line>
                            <line x1="1026" y1="540" x2="972" y2="594">
                            </line>
                            <line x1="1080" y1="540" x2="1026" y2="594">
                            </line>
                            <line x1="1080" y1="540" x2="1134" y2="594">
                            </line>
                            <line x1="1134" y1="540" x2="1188" y2="594">
                            </line>
                            <line x1="1242" y1="540" x2="1188" y2="594">
                            </line>
                            <line x1="1296" y1="540" x2="1242" y2="594">
                            </line>
                            <line x1="1350" y1="540" x2="1296" y2="594">
                            </line>
                            <line x1="1350" y1="540" x2="1404" y2="594">
                            </line>
                            <line x1="1458" y1="540" x2="1404" y2="594">
                            </line>
                            <line x1="0" y1="594" x2="54" y2="648">
                            </line>
                            <line x1="54" y1="594" x2="108" y2="648">
                            </line>
                            <line x1="108" y1="594" x2="162" y2="648">
                            </line>
                            <line x1="162" y1="594" x2="216" y2="648">
                            </line>
                            <line x1="270" y1="594" x2="216" y2="648">
                            </line>
                            <line x1="270" y1="594" x2="324" y2="648">
                            </line>
                            <line x1="378" y1="594" x2="324" y2="648">
                            </line>
                            <line x1="432" y1="594" x2="378" y2="648">
                            </line>
                            <line x1="486" y1="594" x2="432" y2="648">
                            </line>
                            <line x1="486" y1="594" x2="540" y2="648">
                            </line>
                            <line x1="594" y1="594" x2="540" y2="648">
                            </line>
                            <line x1="594" y1="594" x2="648" y2="648">
                            </line>
                            <line x1="648" y1="594" x2="702" y2="648">
                            </line>
                            <line x1="702" y1="594" x2="756" y2="648">
                            </line>
                            <line x1="756" y1="594" x2="810" y2="648">
                            </line>
                            <line x1="864" y1="594" x2="810" y2="648">
                            </line>
                            <line x1="918" y1="594" x2="864" y2="648">
                            </line>
                            <line x1="972" y1="594" x2="918" y2="648">
                            </line>
                            <line x1="1026" y1="594" x2="972" y2="648">
                            </line>
                            <line x1="1080" y1="594" x2="1026" y2="648">
                            </line>
                            <line x1="1134" y1="594" x2="1080" y2="648">
                            </line>
                            <line x1="1188" y1="594" x2="1134" y2="648">
                            </line>
                            <line x1="1188" y1="594" x2="1242" y2="648">
                            </line>
                            <line x1="1296" y1="594" x2="1242" y2="648">
                            </line>
                            <line x1="1296" y1="594" x2="1350" y2="648">
                            </line>
                            <line x1="1350" y1="594" x2="1404" y2="648">
                            </line>
                            <line x1="1458" y1="594" x2="1404" y2="648">
                            </line>
                            <line x1="0" y1="648" x2="54" y2="702">
                            </line>
                            <line x1="54" y1="648" x2="108" y2="702">
                            </line>
                            <line x1="162" y1="648" x2="108" y2="702">
                            </line>
                            <line x1="216" y1="648" x2="162" y2="702">
                            </line>
                            <line x1="216" y1="648" x2="270" y2="702">
                            </line>
                            <line x1="324" y1="648" x2="270" y2="702">
                            </line>
                            <line x1="324" y1="648" x2="378" y2="702">
                            </line>
                            <line x1="432" y1="648" x2="378" y2="702">
                            </line>
                            <line x1="432" y1="648" x2="486" y2="702">
                            </line>
                            <line x1="486" y1="648" x2="540" y2="702">
                            </line>
                            <line x1="594" y1="648" x2="540" y2="702">
                            </line>
                            <line x1="648" y1="648" x2="594" y2="702">
                            </line>
                            <line x1="648" y1="648" x2="702" y2="702">
                            </line>
                            <line x1="702" y1="648" x2="756" y2="702">
                            </line>
                            <line x1="810" y1="648" x2="756" y2="702">
                            </line>
                            <line x1="864" y1="648" x2="810" y2="702">
                            </line>
                            <line x1="918" y1="648" x2="864" y2="702">
                            </line>
                            <line x1="972" y1="648" x2="918" y2="702">
                            </line>
                            <line x1="1026" y1="648" x2="972" y2="702">
                            </line>
                            <line x1="1080" y1="648" x2="1026" y2="702">
                            </line>
                            <line x1="1080" y1="648" x2="1134" y2="702">
                            </line>
                            <line x1="1134" y1="648" x2="1188" y2="702">
                            </line>
                            <line x1="1188" y1="648" x2="1242" y2="702">
                            </line>
                            <line x1="1242" y1="648" x2="1296" y2="702">
                            </line>
                            <line x1="1350" y1="648" x2="1296" y2="702">
                            </line>
                            <line x1="1350" y1="648" x2="1404" y2="702">
                            </line>
                            <line x1="1458" y1="648" x2="1404" y2="702">
                            </line>
                            <line x1="54" y1="702" x2="0" y2="756">
                            </line>
                            <line x1="108" y1="702" x2="54" y2="756">
                            </line>
                            <line x1="162" y1="702" x2="108" y2="756">
                            </line>
                            <line x1="216" y1="702" x2="162" y2="756">
                            </line>
                            <line x1="216" y1="702" x2="270" y2="756">
                            </line>
                            <line x1="270" y1="702" x2="324" y2="756">
                            </line>
                            <line x1="324" y1="702" x2="378" y2="756">
                            </line>
                            <line x1="378" y1="702" x2="432" y2="756">
                            </line>
                            <line x1="486" y1="702" x2="432" y2="756">
                            </line>
                            <line x1="486" y1="702" x2="540" y2="756">
                            </line>
                            <line x1="540" y1="702" x2="594" y2="756">
                            </line>
                            <line x1="594" y1="702" x2="648" y2="756">
                            </line>
                            <line x1="702" y1="702" x2="648" y2="756">
                            </line>
                            <line x1="756" y1="702" x2="702" y2="756">
                            </line>
                            <line x1="756" y1="702" x2="810" y2="756">
                            </line>
                            <line x1="810" y1="702" x2="864" y2="756">
                            </line>
                            <line x1="864" y1="702" x2="918" y2="756">
                            </line>
                            <line x1="918" y1="702" x2="972" y2="756">
                            </line>
                            <line x1="1026" y1="702" x2="972" y2="756">
                            </line>
                            <line x1="1080" y1="702" x2="1026" y2="756">
                            </line>
                            <line x1="1134" y1="702" x2="1080" y2="756">
                            </line>
                            <line x1="1188" y1="702" x2="1134" y2="756">
                            </line>
                            <line x1="1188" y1="702" x2="1242" y2="756">
                            </line>
                            <line x1="1242" y1="702" x2="1296" y2="756">
                            </line>
                            <line x1="1350" y1="702" x2="1296" y2="756">
                            </line>
                            <line x1="1404" y1="702" x2="1350" y2="756">
                            </line>
                            <line x1="1404" y1="702" x2="1458" y2="756">
                            </line>
                            <line x1="0" y1="756" x2="54" y2="810">
                            </line>
                            <line x1="54" y1="756" x2="108" y2="810">
                            </line>
                            <line x1="108" y1="756" x2="162" y2="810">
                            </line>
                            <line x1="162" y1="756" x2="216" y2="810">
                            </line>
                            <line x1="270" y1="756" x2="216" y2="810">
                            </line>
                            <line x1="324" y1="756" x2="270" y2="810">
                            </line>
                            <line x1="378" y1="756" x2="324" y2="810">
                            </line>
                            <line x1="432" y1="756" x2="378" y2="810">
                            </line>
                            <line x1="486" y1="756" x2="432" y2="810">
                            </line>
                            <line x1="540" y1="756" x2="486" y2="810">
                            </line>
                            <line x1="594" y1="756" x2="540" y2="810">
                            </line>
                            <line x1="594" y1="756" x2="648" y2="810">
                            </line>
                            <line x1="648" y1="756" x2="702" y2="810">
                            </line>
                            <line x1="756" y1="756" x2="702" y2="810">
                            </line>
                            <line x1="756" y1="756" x2="810" y2="810">
                            </line>
                            <line x1="810" y1="756" x2="864" y2="810">
                            </line>
                            <line x1="864" y1="756" x2="918" y2="810">
                            </line>
                            <line x1="972" y1="756" x2="918" y2="810">
                            </line>
                            <line x1="1026" y1="756" x2="972" y2="810">
                            </line>
                            <line x1="1080" y1="756" x2="1026" y2="810">
                            </line>
                            <line x1="1080" y1="756" x2="1134" y2="810">
                            </line>
                            <line x1="1134" y1="756" x2="1188" y2="810">
                            </line>
                            <line x1="1242" y1="756" x2="1188" y2="810">
                            </line>
                            <line x1="1296" y1="756" x2="1242" y2="810">
                            </line>
                            <line x1="1350" y1="756" x2="1296" y2="810">
                            </line>
                            <line x1="1404" y1="756" x2="1350" y2="810">
                            </line>
                            <line x1="1458" y1="756" x2="1404" y2="810">
                            </line>
                        </g>
                        <g class="text-x-white" stroke-width="4" stroke="currentColor" fill="none"
                            stroke-linecap="round">
                            <line x1="54" y1="0" x2="0" y2="54"></line>
                            <line x1="108" y1="0" x2="54" y2="54"></line>
                            <line x1="108" y1="0" x2="162" y2="54"></line>
                            <line x1="216" y1="0" x2="162" y2="54"></line>
                            <line x1="216" y1="0" x2="270" y2="54"></line>
                            <line x1="270" y1="0" x2="324" y2="54"></line>
                            <line x1="324" y1="0" x2="378" y2="54"></line>
                            <line x1="378" y1="0" x2="432" y2="54"></line>
                            <line x1="486" y1="0" x2="432" y2="54"></line>
                            <line x1="540" y1="0" x2="486" y2="54"></line>
                            <line x1="594" y1="0" x2="540" y2="54"></line>
                            <line x1="648" y1="0" x2="594" y2="54"></line>
                            <line x1="702" y1="0" x2="648" y2="54"></line>
                            <line x1="702" y1="0" x2="756" y2="54"></line>
                            <line x1="810" y1="0" x2="756" y2="54"></line>
                            <line x1="864" y1="0" x2="810" y2="54"></line>
                            <line x1="864" y1="0" x2="918" y2="54"></line>
                            <line x1="918" y1="0" x2="972" y2="54"></line>
                            <line x1="1026" y1="0" x2="972" y2="54"></line>
                            <line x1="1026" y1="0" x2="1080" y2="54"></line>
                            <line x1="1080" y1="0" x2="1134" y2="54"></line>
                            <line x1="1188" y1="0" x2="1134" y2="54"></line>
                            <line x1="1242" y1="0" x2="1188" y2="54"></line>
                            <line x1="1296" y1="0" x2="1242" y2="54"></line>
                            <line x1="1350" y1="0" x2="1296" y2="54"></line>
                            <line x1="1350" y1="0" x2="1404" y2="54"></line>
                            <line x1="1404" y1="0" x2="1458" y2="54"></line>
                            <line x1="0" y1="54" x2="54" y2="108"></line>
                            <line x1="108" y1="54" x2="54" y2="108"></line>
                            <line x1="162" y1="54" x2="108" y2="108"></line>
                            <line x1="162" y1="54" x2="216" y2="108"></line>
                            <line x1="216" y1="54" x2="270" y2="108"></line>
                            <line x1="324" y1="54" x2="270" y2="108"></line>
                            <line x1="378" y1="54" x2="324" y2="108"></line>
                            <line x1="378" y1="54" x2="432" y2="108"></line>
                            <line x1="432" y1="54" x2="486" y2="108"></line>
                            <line x1="540" y1="54" x2="486" y2="108"></line>
                            <line x1="594" y1="54" x2="540" y2="108"></line>
                            <line x1="594" y1="54" x2="648" y2="108"></line>
                            <line x1="702" y1="54" x2="648" y2="108"></line>
                            <line x1="702" y1="54" x2="756" y2="108"></line>
                            <line x1="810" y1="54" x2="756" y2="108"></line>
                            <line x1="810" y1="54" x2="864" y2="108"></line>
                            <line x1="918" y1="54" x2="864" y2="108"></line>
                            <line x1="972" y1="54" x2="918" y2="108"></line>
                            <line x1="972" y1="54" x2="1026" y2="108"></line>
                            <line x1="1026" y1="54" x2="1080" y2="108"></line>
                            <line x1="1134" y1="54" x2="1080" y2="108"></line>
                            <line x1="1188" y1="54" x2="1134" y2="108"></line>
                            <line x1="1242" y1="54" x2="1188" y2="108"></line>
                            <line x1="1242" y1="54" x2="1296" y2="108"></line>
                            <line x1="1296" y1="54" x2="1350" y2="108"></line>
                            <line x1="1350" y1="54" x2="1404" y2="108"></line>
                            <line x1="1458" y1="54" x2="1404" y2="108"></line>
                            <line x1="54" y1="108" x2="0" y2="162"></line>
                            <line x1="108" y1="108" x2="54" y2="162"></line>
                            <line x1="162" y1="108" x2="108" y2="162"></line>
                            <line x1="216" y1="108" x2="162" y2="162"></line>
                            <line x1="270" y1="108" x2="216" y2="162"></line>
                            <line x1="270" y1="108" x2="324" y2="162"></line>
                            <line x1="378" y1="108" x2="324" y2="162"></line>
                            <line x1="432" y1="108" x2="378" y2="162"></line>
                            <line x1="486" y1="108" x2="432" y2="162"></line>
                            <line x1="540" y1="108" x2="486" y2="162"></line>
                            <line x1="594" y1="108" x2="540" y2="162"></line>
                            <line x1="594" y1="108" x2="648" y2="162"></line>
                            <line x1="702" y1="108" x2="648" y2="162"></line>
                            <line x1="702" y1="108" x2="756" y2="162"></line>
                            <line x1="756" y1="108" x2="810" y2="162"></line>
                            <line x1="810" y1="108" x2="864" y2="162"></line>
                            <line x1="864" y1="108" x2="918" y2="162"></line>
                            <line x1="972" y1="108" x2="918" y2="162"></line>
                            <line x1="1026" y1="108" x2="972" y2="162"></line>
                            <line x1="1080" y1="108" x2="1026" y2="162"></line>
                            <line x1="1134" y1="108" x2="1080" y2="162"></line>
                            <line x1="1188" y1="108" x2="1134" y2="162"></line>
                            <line x1="1242" y1="108" x2="1188" y2="162"></line>
                            <line x1="1296" y1="108" x2="1242" y2="162"></line>
                            <line x1="1296" y1="108" x2="1350" y2="162"></line>
                            <line x1="1350" y1="108" x2="1404" y2="162"></line>
                            <line x1="1404" y1="108" x2="1458" y2="162"></line>
                            <line x1="54" y1="162" x2="0" y2="216"></line>
                            <line x1="54" y1="162" x2="108" y2="216"></line>
                            <line x1="162" y1="162" x2="108" y2="216"></line>
                            <line x1="162" y1="162" x2="216" y2="216"></line>
                            <line x1="270" y1="162" x2="216" y2="216"></line>
                            <line x1="270" y1="162" x2="324" y2="216"></line>
                            <line x1="378" y1="162" x2="324" y2="216"></line>
                            <line x1="432" y1="162" x2="378" y2="216"></line>
                            <line x1="486" y1="162" x2="432" y2="216"></line>
                            <line x1="540" y1="162" x2="486" y2="216"></line>
                            <line x1="540" y1="162" x2="594" y2="216"></line>
                            <line x1="648" y1="162" x2="594" y2="216"></line>
                            <line x1="702" y1="162" x2="648" y2="216"></line>
                            <line x1="702" y1="162" x2="756" y2="216"></line>
                            <line x1="810" y1="162" x2="756" y2="216"></line>
                            <line x1="810" y1="162" x2="864" y2="216"></line>
                            <line x1="918" y1="162" x2="864" y2="216"></line>
                            <line x1="972" y1="162" x2="918" y2="216"></line>
                            <line x1="1026" y1="162" x2="972" y2="216"></line>
                            <line x1="1026" y1="162" x2="1080" y2="216"></line>
                            <line x1="1134" y1="162" x2="1080" y2="216"></line>
                            <line x1="1134" y1="162" x2="1188" y2="216"></line>
                            <line x1="1188" y1="162" x2="1242" y2="216"></line>
                            <line x1="1296" y1="162" x2="1242" y2="216"></line>
                            <line x1="1350" y1="162" x2="1296" y2="216"></line>
                            <line x1="1350" y1="162" x2="1404" y2="216"></line>
                            <line x1="1458" y1="162" x2="1404" y2="216"></line>
                            <line x1="54" y1="216" x2="0" y2="270"></line>
                            <line x1="108" y1="216" x2="54" y2="270"></line>
                            <line x1="108" y1="216" x2="162" y2="270"></line>
                            <line x1="216" y1="216" x2="162" y2="270"></line>
                            <line x1="216" y1="216" x2="270" y2="270"></line>
                            <line x1="270" y1="216" x2="324" y2="270"></line>
                            <line x1="324" y1="216" x2="378" y2="270"></line>
                            <line x1="378" y1="216" x2="432" y2="270"></line>
                            <line x1="486" y1="216" x2="432" y2="270"></line>
                            <line x1="486" y1="216" x2="540" y2="270"></line>
                            <line x1="594" y1="216" x2="540" y2="270"></line>
                            <line x1="648" y1="216" x2="594" y2="270"></line>
                            <line x1="648" y1="216" x2="702" y2="270"></line>
                            <line x1="702" y1="216" x2="756" y2="270"></line>
                            <line x1="810" y1="216" x2="756" y2="270"></line>
                            <line x1="864" y1="216" x2="810" y2="270"></line>
                            <line x1="864" y1="216" x2="918" y2="270"></line>
                            <line x1="972" y1="216" x2="918" y2="270"></line>
                            <line x1="1026" y1="216" x2="972" y2="270"></line>
                            <line x1="1080" y1="216" x2="1026" y2="270"></line>
                            <line x1="1134" y1="216" x2="1080" y2="270"></line>
                            <line x1="1188" y1="216" x2="1134" y2="270"></line>
                            <line x1="1242" y1="216" x2="1188" y2="270"></line>
                            <line x1="1296" y1="216" x2="1242" y2="270"></line>
                            <line x1="1350" y1="216" x2="1296" y2="270"></line>
                            <line x1="1404" y1="216" x2="1350" y2="270"></line>
                            <line x1="1458" y1="216" x2="1404" y2="270"></line>
                            <line x1="54" y1="270" x2="0" y2="324"></line>
                            <line x1="108" y1="270" x2="54" y2="324"></line>
                            <line x1="162" y1="270" x2="108" y2="324"></line>
                            <line x1="162" y1="270" x2="216" y2="324"></line>
                            <line x1="216" y1="270" x2="270" y2="324"></line>
                            <line x1="324" y1="270" x2="270" y2="324"></line>
                            <line x1="378" y1="270" x2="324" y2="324"></line>
                            <line x1="378" y1="270" x2="432" y2="324"></line>
                            <line x1="432" y1="270" x2="486" y2="324"></line>
                            <line x1="486" y1="270" x2="540" y2="324"></line>
                            <line x1="594" y1="270" x2="540" y2="324"></line>
                            <line x1="648" y1="270" x2="594" y2="324"></line>
                            <line x1="702" y1="270" x2="648" y2="324"></line>
                            <line x1="756" y1="270" x2="702" y2="324"></line>
                            <line x1="756" y1="270" x2="810" y2="324"></line>
                            <line x1="864" y1="270" x2="810" y2="324"></line>
                            <line x1="864" y1="270" x2="918" y2="324"></line>
                            <line x1="972" y1="270" x2="918" y2="324"></line>
                            <line x1="1026" y1="270" x2="972" y2="324"></line>
                            <line x1="1026" y1="270" x2="1080" y2="324"></line>
                            <line x1="1080" y1="270" x2="1134" y2="324"></line>
                            <line x1="1188" y1="270" x2="1134" y2="324"></line>
                            <line x1="1242" y1="270" x2="1188" y2="324"></line>
                            <line x1="1242" y1="270" x2="1296" y2="324"></line>
                            <line x1="1296" y1="270" x2="1350" y2="324"></line>
                            <line x1="1404" y1="270" x2="1350" y2="324"></line>
                            <line x1="1458" y1="270" x2="1404" y2="324"></line>
                            <line x1="54" y1="324" x2="0" y2="378"></line>
                            <line x1="108" y1="324" x2="54" y2="378"></line>
                            <line x1="162" y1="324" x2="108" y2="378"></line>
                            <line x1="162" y1="324" x2="216" y2="378"></line>
                            <line x1="216" y1="324" x2="270" y2="378"></line>
                            <line x1="270" y1="324" x2="324" y2="378"></line>
                            <line x1="324" y1="324" x2="378" y2="378"></line>
                            <line x1="378" y1="324" x2="432" y2="378">
                            </line>
                            <line x1="432" y1="324" x2="486" y2="378">
                            </line>
                            <line x1="540" y1="324" x2="486" y2="378">
                            </line>
                            <line x1="540" y1="324" x2="594" y2="378">
                            </line>
                            <line x1="594" y1="324" x2="648" y2="378">
                            </line>
                            <line x1="702" y1="324" x2="648" y2="378">
                            </line>
                            <line x1="756" y1="324" x2="702" y2="378">
                            </line>
                            <line x1="810" y1="324" x2="756" y2="378">
                            </line>
                            <line x1="810" y1="324" x2="864" y2="378">
                            </line>
                            <line x1="864" y1="324" x2="918" y2="378">
                            </line>
                            <line x1="918" y1="324" x2="972" y2="378">
                            </line>
                            <line x1="1026" y1="324" x2="972" y2="378">
                            </line>
                            <line x1="1080" y1="324" x2="1026" y2="378">
                            </line>
                            <line x1="1134" y1="324" x2="1080" y2="378">
                            </line>
                            <line x1="1134" y1="324" x2="1188" y2="378">
                            </line>
                            <line x1="1188" y1="324" x2="1242" y2="378">
                            </line>
                            <line x1="1242" y1="324" x2="1296" y2="378">
                            </line>
                            <line x1="1350" y1="324" x2="1296" y2="378">
                            </line>
                            <line x1="1404" y1="324" x2="1350" y2="378">
                            </line>
                            <line x1="1404" y1="324" x2="1458" y2="378">
                            </line>
                            <line x1="54" y1="378" x2="0" y2="432">
                            </line>
                            <line x1="54" y1="378" x2="108" y2="432">
                            </line>
                            <line x1="162" y1="378" x2="108" y2="432">
                            </line>
                            <line x1="216" y1="378" x2="162" y2="432">
                            </line>
                            <line x1="216" y1="378" x2="270" y2="432">
                            </line>
                            <line x1="270" y1="378" x2="324" y2="432">
                            </line>
                            <line x1="378" y1="378" x2="324" y2="432">
                            </line>
                            <line x1="378" y1="378" x2="432" y2="432">
                            </line>
                            <line x1="432" y1="378" x2="486" y2="432">
                            </line>
                            <line x1="540" y1="378" x2="486" y2="432">
                            </line>
                            <line x1="540" y1="378" x2="594" y2="432">
                            </line>
                            <line x1="648" y1="378" x2="594" y2="432">
                            </line>
                            <line x1="702" y1="378" x2="648" y2="432">
                            </line>
                            <line x1="756" y1="378" x2="702" y2="432">
                            </line>
                            <line x1="810" y1="378" x2="756" y2="432">
                            </line>
                            <line x1="810" y1="378" x2="864" y2="432">
                            </line>
                            <line x1="864" y1="378" x2="918" y2="432">
                            </line>
                            <line x1="918" y1="378" x2="972" y2="432">
                            </line>
                            <line x1="972" y1="378" x2="1026" y2="432">
                            </line>
                            <line x1="1026" y1="378" x2="1080" y2="432">
                            </line>
                            <line x1="1134" y1="378" x2="1080" y2="432">
                            </line>
                            <line x1="1134" y1="378" x2="1188" y2="432">
                            </line>
                            <line x1="1188" y1="378" x2="1242" y2="432">
                            </line>
                            <line x1="1296" y1="378" x2="1242" y2="432">
                            </line>
                            <line x1="1350" y1="378" x2="1296" y2="432">
                            </line>
                            <line x1="1404" y1="378" x2="1350" y2="432">
                            </line>
                            <line x1="1458" y1="378" x2="1404" y2="432">
                            </line>
                            <line x1="0" y1="432" x2="54" y2="486">
                            </line>
                            <line x1="54" y1="432" x2="108" y2="486">
                            </line>
                            <line x1="108" y1="432" x2="162" y2="486">
                            </line>
                            <line x1="162" y1="432" x2="216" y2="486">
                            </line>
                            <line x1="270" y1="432" x2="216" y2="486">
                            </line>
                            <line x1="270" y1="432" x2="324" y2="486">
                            </line>
                            <line x1="378" y1="432" x2="324" y2="486">
                            </line>
                            <line x1="432" y1="432" x2="378" y2="486">
                            </line>
                            <line x1="432" y1="432" x2="486" y2="486">
                            </line>
                            <line x1="540" y1="432" x2="486" y2="486">
                            </line>
                            <line x1="540" y1="432" x2="594" y2="486">
                            </line>
                            <line x1="594" y1="432" x2="648" y2="486">
                            </line>
                            <line x1="648" y1="432" x2="702" y2="486">
                            </line>
                            <line x1="702" y1="432" x2="756" y2="486">
                            </line>
                            <line x1="756" y1="432" x2="810" y2="486">
                            </line>
                            <line x1="864" y1="432" x2="810" y2="486">
                            </line>
                            <line x1="864" y1="432" x2="918" y2="486">
                            </line>
                            <line x1="972" y1="432" x2="918" y2="486">
                            </line>
                            <line x1="1026" y1="432" x2="972" y2="486">
                            </line>
                            <line x1="1026" y1="432" x2="1080" y2="486">
                            </line>
                            <line x1="1080" y1="432" x2="1134" y2="486">
                            </line>
                            <line x1="1188" y1="432" x2="1134" y2="486">
                            </line>
                            <line x1="1242" y1="432" x2="1188" y2="486">
                            </line>
                            <line x1="1296" y1="432" x2="1242" y2="486">
                            </line>
                            <line x1="1296" y1="432" x2="1350" y2="486">
                            </line>
                            <line x1="1350" y1="432" x2="1404" y2="486">
                            </line>
                            <line x1="1458" y1="432" x2="1404" y2="486">
                            </line>
                            <line x1="54" y1="486" x2="0" y2="540">
                            </line>
                            <line x1="108" y1="486" x2="54" y2="540">
                            </line>
                            <line x1="162" y1="486" x2="108" y2="540">
                            </line>
                            <line x1="162" y1="486" x2="216" y2="540">
                            </line>
                            <line x1="270" y1="486" x2="216" y2="540">
                            </line>
                            <line x1="270" y1="486" x2="324" y2="540">
                            </line>
                            <line x1="324" y1="486" x2="378" y2="540">
                            </line>
                            <line x1="432" y1="486" x2="378" y2="540">
                            </line>
                            <line x1="432" y1="486" x2="486" y2="540">
                            </line>
                            <line x1="540" y1="486" x2="486" y2="540">
                            </line>
                            <line x1="540" y1="486" x2="594" y2="540">
                            </line>
                            <line x1="648" y1="486" x2="594" y2="540">
                            </line>
                            <line x1="648" y1="486" x2="702" y2="540">
                            </line>
                            <line x1="702" y1="486" x2="756" y2="540">
                            </line>
                            <line x1="810" y1="486" x2="756" y2="540">
                            </line>
                            <line x1="864" y1="486" x2="810" y2="540">
                            </line>
                            <line x1="918" y1="486" x2="864" y2="540">
                            </line>
                            <line x1="918" y1="486" x2="972" y2="540">
                            </line>
                            <line x1="1026" y1="486" x2="972" y2="540">
                            </line>
                            <line x1="1026" y1="486" x2="1080" y2="540">
                            </line>
                            <line x1="1134" y1="486" x2="1080" y2="540">
                            </line>
                            <line x1="1188" y1="486" x2="1134" y2="540">
                            </line>
                            <line x1="1188" y1="486" x2="1242" y2="540">
                            </line>
                            <line x1="1296" y1="486" x2="1242" y2="540">
                            </line>
                            <line x1="1296" y1="486" x2="1350" y2="540">
                            </line>
                            <line x1="1404" y1="486" x2="1350" y2="540">
                            </line>
                            <line x1="1458" y1="486" x2="1404" y2="540">
                            </line>
                            <line x1="0" y1="540" x2="54" y2="594">
                            </line>
                            <line x1="108" y1="540" x2="54" y2="594">
                            </line>
                            <line x1="162" y1="540" x2="108" y2="594">
                            </line>
                            <line x1="216" y1="540" x2="162" y2="594">
                            </line>
                            <line x1="216" y1="540" x2="270" y2="594">
                            </line>
                            <line x1="270" y1="540" x2="324" y2="594">
                            </line>
                            <line x1="378" y1="540" x2="324" y2="594">
                            </line>
                            <line x1="432" y1="540" x2="378" y2="594">
                            </line>
                            <line x1="432" y1="540" x2="486" y2="594">
                            </line>
                            <line x1="540" y1="540" x2="486" y2="594">
                            </line>
                            <line x1="594" y1="540" x2="540" y2="594">
                            </line>
                            <line x1="594" y1="540" x2="648" y2="594">
                            </line>
                            <line x1="702" y1="540" x2="648" y2="594">
                            </line>
                            <line x1="756" y1="540" x2="702" y2="594">
                            </line>
                            <line x1="756" y1="540" x2="810" y2="594">
                            </line>
                            <line x1="864" y1="540" x2="810" y2="594">
                            </line>
                            <line x1="918" y1="540" x2="864" y2="594">
                            </line>
                            <line x1="972" y1="540" x2="918" y2="594">
                            </line>
                            <line x1="1026" y1="540" x2="972" y2="594">
                            </line>
                            <line x1="1080" y1="540" x2="1026" y2="594">
                            </line>
                            <line x1="1080" y1="540" x2="1134" y2="594">
                            </line>
                            <line x1="1134" y1="540" x2="1188" y2="594">
                            </line>
                            <line x1="1242" y1="540" x2="1188" y2="594">
                            </line>
                            <line x1="1296" y1="540" x2="1242" y2="594">
                            </line>
                            <line x1="1350" y1="540" x2="1296" y2="594">
                            </line>
                            <line x1="1350" y1="540" x2="1404" y2="594">
                            </line>
                            <line x1="1458" y1="540" x2="1404" y2="594">
                            </line>
                            <line x1="0" y1="594" x2="54" y2="648">
                            </line>
                            <line x1="54" y1="594" x2="108" y2="648">
                            </line>
                            <line x1="108" y1="594" x2="162" y2="648">
                            </line>
                            <line x1="162" y1="594" x2="216" y2="648">
                            </line>
                            <line x1="270" y1="594" x2="216" y2="648">
                            </line>
                            <line x1="270" y1="594" x2="324" y2="648">
                            </line>
                            <line x1="378" y1="594" x2="324" y2="648">
                            </line>
                            <line x1="432" y1="594" x2="378" y2="648">
                            </line>
                            <line x1="486" y1="594" x2="432" y2="648">
                            </line>
                            <line x1="486" y1="594" x2="540" y2="648">
                            </line>
                            <line x1="594" y1="594" x2="540" y2="648">
                            </line>
                            <line x1="594" y1="594" x2="648" y2="648">
                            </line>
                            <line x1="648" y1="594" x2="702" y2="648">
                            </line>
                            <line x1="702" y1="594" x2="756" y2="648">
                            </line>
                            <line x1="756" y1="594" x2="810" y2="648">
                            </line>
                            <line x1="864" y1="594" x2="810" y2="648">
                            </line>
                            <line x1="918" y1="594" x2="864" y2="648">
                            </line>
                            <line x1="972" y1="594" x2="918" y2="648">
                            </line>
                            <line x1="1026" y1="594" x2="972" y2="648">
                            </line>
                            <line x1="1080" y1="594" x2="1026" y2="648">
                            </line>
                            <line x1="1134" y1="594" x2="1080" y2="648">
                            </line>
                            <line x1="1188" y1="594" x2="1134" y2="648">
                            </line>
                            <line x1="1188" y1="594" x2="1242" y2="648">
                            </line>
                            <line x1="1296" y1="594" x2="1242" y2="648">
                            </line>
                            <line x1="1296" y1="594" x2="1350" y2="648">
                            </line>
                            <line x1="1350" y1="594" x2="1404" y2="648">
                            </line>
                            <line x1="1458" y1="594" x2="1404" y2="648">
                            </line>
                            <line x1="0" y1="648" x2="54" y2="702">
                            </line>
                            <line x1="54" y1="648" x2="108" y2="702">
                            </line>
                            <line x1="162" y1="648" x2="108" y2="702">
                            </line>
                            <line x1="216" y1="648" x2="162" y2="702">
                            </line>
                            <line x1="216" y1="648" x2="270" y2="702">
                            </line>
                            <line x1="324" y1="648" x2="270" y2="702">
                            </line>
                            <line x1="324" y1="648" x2="378" y2="702">
                            </line>
                            <line x1="432" y1="648" x2="378" y2="702">
                            </line>
                            <line x1="432" y1="648" x2="486" y2="702">
                            </line>
                            <line x1="486" y1="648" x2="540" y2="702">
                            </line>
                            <line x1="594" y1="648" x2="540" y2="702">
                            </line>
                            <line x1="648" y1="648" x2="594" y2="702">
                            </line>
                            <line x1="648" y1="648" x2="702" y2="702">
                            </line>
                            <line x1="702" y1="648" x2="756" y2="702">
                            </line>
                            <line x1="810" y1="648" x2="756" y2="702">
                            </line>
                            <line x1="864" y1="648" x2="810" y2="702">
                            </line>
                            <line x1="918" y1="648" x2="864" y2="702">
                            </line>
                            <line x1="972" y1="648" x2="918" y2="702">
                            </line>
                            <line x1="1026" y1="648" x2="972" y2="702">
                            </line>
                            <line x1="1080" y1="648" x2="1026" y2="702">
                            </line>
                            <line x1="1080" y1="648" x2="1134" y2="702">
                            </line>
                            <line x1="1134" y1="648" x2="1188" y2="702">
                            </line>
                            <line x1="1188" y1="648" x2="1242" y2="702">
                            </line>
                            <line x1="1242" y1="648" x2="1296" y2="702">
                            </line>
                            <line x1="1350" y1="648" x2="1296" y2="702">
                            </line>
                            <line x1="1350" y1="648" x2="1404" y2="702">
                            </line>
                            <line x1="1458" y1="648" x2="1404" y2="702">
                            </line>
                            <line x1="54" y1="702" x2="0" y2="756">
                            </line>
                            <line x1="108" y1="702" x2="54" y2="756">
                            </line>
                            <line x1="162" y1="702" x2="108" y2="756">
                            </line>
                            <line x1="216" y1="702" x2="162" y2="756">
                            </line>
                            <line x1="216" y1="702" x2="270" y2="756">
                            </line>
                            <line x1="270" y1="702" x2="324" y2="756">
                            </line>
                            <line x1="324" y1="702" x2="378" y2="756">
                            </line>
                            <line x1="378" y1="702" x2="432" y2="756">
                            </line>
                            <line x1="486" y1="702" x2="432" y2="756">
                            </line>
                            <line x1="486" y1="702" x2="540" y2="756">
                            </line>
                            <line x1="540" y1="702" x2="594" y2="756">
                            </line>
                            <line x1="594" y1="702" x2="648" y2="756">
                            </line>
                            <line x1="702" y1="702" x2="648" y2="756">
                            </line>
                            <line x1="756" y1="702" x2="702" y2="756">
                            </line>
                            <line x1="756" y1="702" x2="810" y2="756">
                            </line>
                            <line x1="810" y1="702" x2="864" y2="756">
                            </line>
                            <line x1="864" y1="702" x2="918" y2="756">
                            </line>
                            <line x1="918" y1="702" x2="972" y2="756">
                            </line>
                            <line x1="1026" y1="702" x2="972" y2="756">
                            </line>
                            <line x1="1080" y1="702" x2="1026" y2="756">
                            </line>
                            <line x1="1134" y1="702" x2="1080" y2="756">
                            </line>
                            <line x1="1188" y1="702" x2="1134" y2="756">
                            </line>
                            <line x1="1188" y1="702" x2="1242" y2="756">
                            </line>
                            <line x1="1242" y1="702" x2="1296" y2="756">
                            </line>
                            <line x1="1350" y1="702" x2="1296" y2="756">
                            </line>
                            <line x1="1404" y1="702" x2="1350" y2="756">
                            </line>
                            <line x1="1404" y1="702" x2="1458" y2="756">
                            </line>
                            <line x1="0" y1="756" x2="54" y2="810">
                            </line>
                            <line x1="54" y1="756" x2="108" y2="810">
                            </line>
                            <line x1="108" y1="756" x2="162" y2="810">
                            </line>
                            <line x1="162" y1="756" x2="216" y2="810">
                            </line>
                            <line x1="270" y1="756" x2="216" y2="810">
                            </line>
                            <line x1="324" y1="756" x2="270" y2="810">
                            </line>
                            <line x1="378" y1="756" x2="324" y2="810">
                            </line>
                            <line x1="432" y1="756" x2="378" y2="810">
                            </line>
                            <line x1="486" y1="756" x2="432" y2="810">
                            </line>
                            <line x1="540" y1="756" x2="486" y2="810">
                            </line>
                            <line x1="594" y1="756" x2="540" y2="810">
                            </line>
                            <line x1="594" y1="756" x2="648" y2="810">
                            </line>
                            <line x1="648" y1="756" x2="702" y2="810">
                            </line>
                            <line x1="756" y1="756" x2="702" y2="810">
                            </line>
                            <line x1="756" y1="756" x2="810" y2="810">
                            </line>
                            <line x1="810" y1="756" x2="864" y2="810">
                            </line>
                            <line x1="864" y1="756" x2="918" y2="810">
                            </line>
                            <line x1="972" y1="756" x2="918" y2="810">
                            </line>
                            <line x1="1026" y1="756" x2="972" y2="810">
                            </line>
                            <line x1="1080" y1="756" x2="1026" y2="810">
                            </line>
                            <line x1="1080" y1="756" x2="1134" y2="810">
                            </line>
                            <line x1="1134" y1="756" x2="1188" y2="810">
                            </line>
                            <line x1="1242" y1="756" x2="1188" y2="810">
                            </line>
                            <line x1="1296" y1="756" x2="1242" y2="810">
                            </line>
                            <line x1="1350" y1="756" x2="1296" y2="810">
                            </line>
                            <line x1="1404" y1="756" x2="1350" y2="810">
                            </line>
                            <line x1="1458" y1="756" x2="1404" y2="810">
                            </line>
                        </g>
                    </svg>
                    <div class="flex flex-col gap-3">
                        <h3 class="font-x-huge text-start text-x-black text-2xl lg:text-5xl">
                            {{ ucwords(__('trusted by 13,643 businesses')) }} <br>
                            {{ ucwords(__('all around morocco')) }}
                        </h3>
                    </div>
                    <ul class="grid grid-rows-1 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-black text-start text-xl lg:text-3xl">
                                207,930.50 MAD
                            </h5>
                            <p class="text-x-black text-start text-lg">
                                {{ ucfirst(__('reservations paid')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-black text-start text-xl lg:text-3xl">
                                230,312,895
                            </h5>
                            <p class="text-x-black text-start text-lg">
                                {{ ucfirst(__('minutes tracked')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-black text-start text-xl lg:text-3xl">
                                4,000
                            </h5>
                            <p class="text-x-black text-start text-lg">
                                {{ ucfirst(__('reservations completed')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-black text-start text-xl lg:text-3xl">
                                2,648
                            </h5>
                            <p class="text-x-black text-start text-lg">
                                {{ ucfirst(__('agencies signed')) }}.
                            </p>
                        </li>
                    </ul>
                </div>
            </section>
        </main>
    </neo-wrapper>
    <neo-toaster horisontal="end" vertical="start"></neo-toaster>
    @include('shared.base.scripts', ['type' => 'admin'])
    <script>
        const tabs = document.querySelectorAll(".tab-main");

        tabs.forEach(tab => {
            const header = tab.querySelector(".tab-header"),
                content = tab.querySelector(".tab-content");

            header.addEventListener("click", e => {
                tabs.forEach(_tab => {
                    if (tab === _tab) return;
                    _tab.classList.remove("tab-open", "border-x-prime", "bg-x-prime");
                    _tab.classList.add("border-x-light", "bg-x-light");
                    _tab.querySelector(".tab-content").style.maxHeight = "0px";
                });
                if (tab.classList.contains("tab-open")) {
                    tab.classList.remove("tab-open", "border-x-prime", "bg-x-prime");
                    tab.classList.add("border-x-light", "bg-x-light");
                    content.style.maxHeight = "0px";
                } else {
                    tab.classList.add("tab-open", "border-x-prime", "bg-x-prime");
                    tab.classList.remove("border-x-light", "bg-x-light");
                    content.style.maxHeight = "500px";
                }
            });
        });
    </script>
</body>

</html>
