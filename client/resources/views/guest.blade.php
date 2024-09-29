<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ Core::lang('ar') ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('shared.base.styles', ['type' => 'admin'])
    {{-- @yield('styles') --}}
    <title>{{ __('Car Rental') }}</title>
</head>

<body close class="bg-x-white">
    <section id="neo-page-cover">
        <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}" alt="{{ env('APP_NAME') }} logo image"
            class="block w-36" width="916" height="516" loading="lazy" />
    </section>
    <neo-wrapper class="isolate overflow-hidden">
        <header class="flex flex-col gap-8 relative">
            <img src="{{ asset('img/svg/sharpes.svg') }}?v={{ env('APP_VERSION') }}"
                alt="{{ env('APP_NAME') }} sharpes image"
                class="block w-full h-full object-cover absolute inset-0 pointer-events-none z-[-100]" />
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
            <div class="w-full flex flex-wrap"
                style="
                    background-image: linear-gradient(to bottom, transparent 40%, rgb(var(--light)));
                ">
                <div class="p-4 container mx-auto">
                    <div class="w-full lg:w-10/12 mx-auto flex flex-col gap-6 lg:gap-10">
                        <div class="w-full flex flex-col gap-2 lg:gap-4 lg:px-10">
                            <h1 class="font-x-huge text-center text-x-black text-2xl lg:text-5xl rtl:leading-[1.4]">
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
                                class="w-full h-full overflow-hidden rounded-x-huge absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 z-[-100]">
                                <div
                                    class="w-[140%] h-20 lg:h-48 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
                                    <div class="w-full h-full bg-x-prime animate-spin" style="animation-duration: 5s">
                                    </div>
                                </div>
                            </div>
                            <div class="p-1">
                                <img src="{{ asset('img/poster.png') }}?v={{ env('APP_VERSION') }}"
                                    alt="{{ env('APP_NAME') }} poster image"
                                    class="block bg-x-shade w-full shadow-md shadow-x-acent rounded-x-huge"
                                    width="916" height="516" loading="lazy" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="w-full flex flex-col">
            <section class="w-full relative bg-x-light py-6">
                <div class="p-4 container mx-auto flex flex-col gap-10">
                    <div class="flex flex-col gap-3 lg:w-10/12 lg:mx-auto">
                        <h3 class="font-x-thin text-center text-x-black text-xl lg:text-3xl">
                            {{ ucwords(__('why we’re the best choice for your car rental business')) }}
                        </h3>
                        <p class="text-center text-x-black text-base lg:text-xl">
                            {{ ucfirst(__('discover the benefits of choosing a solution that’s tailored to your car rental business needs')) }}
                        </p>
                    </div>
                    <ul class="ui-grid grid grid-rows-1 lg:grid-cols-3 gap-6">
                        @php
                            $bollets = [
                                'all-in-one management' => [
                                    'text' =>
                                        'centralize your fleet, reservations, and customer interactions in a single, streamlined platform',
                                    'path' =>
                                        'm226-488 258-422 258 422H226ZM708-36q-85 0-143.5-60.08Q506-156.17 506-242q0-85 58.5-143.5T708-444q85.83 0 145.92 58.5Q914-327 914-241.5T853.92-96Q793.83-36 708-36ZM98-60v-364h364v364H98Zm610-82q41 0 70.5-28.39 29.5-28.38 29.5-69.5 0-41.11-29.5-69.61T708-338q-41 0-68.5 28.39-27.5 28.38-27.5 69.5 0 41.11 27.5 69.61T708-142Zm-504-24h152v-152H204v152Zm212-428h138l-70-112-68 112Zm69 0ZM356-318Zm354 78Z',
                                ],
                                'intuitive interface' => [
                                    'text' =>
                                        'enjoy a user-friendly experience designed to make managing your business easy and efficient',
                                    'path' =>
                                        'M48-128v-160h80v-438q0-45 30.5-75.5T234-832h638v106H234v438h234v160H48Zm553 0q-22 0-37.5-15.5T548-181v-412q0-22 15.5-37.5T601-646h258q22 0 37.5 15.5T912-593v412q0 22-15.5 37.5T859-128H601Zm53-160h152v-252H654v252Zm0 0h152-152Z',
                                ],
                                'scalable solutions' => [
                                    'text' =>
                                        'adapt and expand with flexible features and plans that grow with your business needs',
                                    'path' =>
                                        'M67-67q0-117 29-198.5T170.5-400Q216-453 273-481.5T387-521v-108q-137-20-228.5-94T67-893h826q0 97-91.5 170.5T573-629v108q57 11 114 39.5T789.5-400Q835-347 864-265.5T893-67H627v-106h153q-23-133-107-192.5T480-425q-109 0-193 59.5T180-173h153v106H67Zm413-661q74 0 133.5-16.5T715-787H245q42 26 101.5 42.5T480-728Zm0 661q-38 0-65.5-27.5T387-160q0-20 7-37t21-29q26-26 92.5-57T663-343q-29 88-60 155t-57 93q-12 14-29 21t-37 7Zm0-661Z',
                                ],
                                'advanced analytics' => [
                                    'text' =>
                                        'utilize advanced reporting tools to gain insights and drive data-driven decisions',
                                    'path' =>
                                        'M114-114v-85l73-73v158h-73Zm165 0v-245l73-73v318h-73Zm165 0v-318l73 74v244h-73Zm165 0v-244l73-73v317h-73Zm165 0v-405l73-73v478h-73ZM114-341v-103l286-284 160 160 287-288v103L560-465 400-625 114-341Z',
                                ],
                                'robust security' => [
                                    'text' =>
                                        'safeguard your business and customer data with our top-tier security and reliable infrastructure',
                                    'path' =>
                                        'M480.02-46Q328-81 229-216.06 130-351.11 130-516v-266l350-132 350 132v265.57Q830-351 731.02-216t-251 170ZM480-156q98-30 164.5-122T722-480H480v-321l-244 91.94v211.78q0 6.72 2.03 17.28H480v324Z',
                                ],
                                '24/7 customer support' => [
                                    'text' =>
                                        'get 24/7 assistance from our dedicated support team for prompt issue resolution',
                                    'path' =>
                                        'M477.86-218q25.14 0 42.64-17.36t17.5-42.5q0-25.14-17.36-42.64t-42.5-17.5q-25.14 0-42.64 17.36t-17.5 42.5q0 25.14 17.36 42.64t42.5 17.5ZM430-386h98q0-37.65 6.5-59.32Q541-467 582-506q26-24 42-49.92t16-62.32Q640-680 593.65-712 547.3-744 484-744q-66 0-106 34t-54 84l86 34q2-17 18.5-40.5T484-656q29 0 44.5 16t15.5 34q0 20-13 37.5T500-536q-50 44-60 64t-10 86Zm50 338q-89.64 0-168.48-34.02-78.84-34.02-137.16-92.34-58.32-58.32-92.34-137.16T48-480q0-89.9 34.08-168.96 34.08-79.07 92.5-137.55Q233-845 311.74-878.5 390.48-912 480-912q89.89 0 168.94 33.5Q728-845 786.5-786.5t92 137.58q33.5 79.09 33.5 169 0 89.92-33.5 168.42Q845-233 786.51-174.58q-58.48 58.42-137.55 92.5Q569.9-48 480-48Zm0-106q136.51 0 231.26-94.74Q806-343.49 806-480t-94.74-231.26Q616.51-806 480-806t-231.26 94.74Q154-616.51 154-480t94.74 231.26Q343.49-154 480-154Zm0-326Z',
                                ],
                            ];
                        @endphp
                        @foreach ($bollets as $head => $arr)
                            <li class="flex flex-wrap gap-2 items-start bg-x-white rounded-x-huge p-6">
                                <div class="flex flex-col gap-1">
                                    <svg class="block mx-auto text-x-prime w-12 h-12 pointer-events-none"
                                        fill="currentcolor" viewBox="0 -960 960 960">
                                        <path d="{{ $arr['path'] }}" />
                                    </svg>
                                    <h5 class="font-x-thin text-x-black text-center text-lg lg:text-xl">
                                        {{ ucwords(__($head)) }}
                                    </h5>
                                    <p class="text-x-black text-center text-base">
                                        {{ ucfirst(__($arr['text'])) }}.
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <section class="w-full py-6 relative isolate overflow-hidden">
                <img src="{{ asset('img/svg/pattern.svg') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} pattern image"
                    class="block w-full h-full object-cover absolute inset-0 pointer-events-none z-[-100]" />
                <div class="p-4 container mx-auto flex flex-col gap-10">
                    <div class="flex flex-col gap-3 lg:w-10/12 lg:mx-auto">
                        <h3 class="font-x-thin text-center text-x-prime text-xl lg:text-3xl">
                            {{ ucwords(__('a cutting-edge, full-stack system for processing car rentals')) }}
                        </h3>
                        <p class="text-center text-x-black text-base lg:text-xl">
                            {{ ucfirst(__('this full-stack solution transforms car rental operations by integrating booking, vehicle management, payments, and reporting into one seamless system. With modern technology and a user-friendly interface, it simplifies fleet management and enhances overall operations')) }}
                        </p>
                    </div>
                    <div class="grid grid-rows-1 grid-cols-1 lg:grid-cols-2 items-center gap-10">
                        <ul class="flex flex-col gap-6 relative isolate pt-4 lg:ms-10">
                            <div
                                class="w-1 h-full absolute top-0 left-[1.625rem] rtl:left-auto rtl:right-[1.625rem] bottom-0 bg-x-shade z-[-100]">
                            </div>
                            @php
                                $bollets = [
                                    'Reservations' => [
                                        'text' =>
                                            'easily manage car rental bookings with real-time availability and a simple scheduling process',
                                        'path' =>
                                            'M482.77-98Q434-135 378-160q-56-25-117.59-25Q221-185 184-174t-71 29q-37 19-71.5-1T7-206v-480q0-26.06 11-48.33Q29-756.61 52-769q47.63-22 99.32-32.5Q203-812 257.24-812q60.26 0 116.51 15Q430-782 480-748.53V-229q51-31 106-50t114-19q36 0 71 7t69 20v-524q17.52 6 34.52 13 17 7 35.48 13 23 10.39 33 33.67 10 23.27 10 49.33v496q0 35-34.5 49.5T847-145q-34-18-71-29t-76.41-11q-60.59 0-114.82 25-54.23 25-102 62ZM560-332v-417l200-208v437L560-332Z',
                                    ],
                                    'Payments' => [
                                        'text' =>
                                            'process payments securely with support for multiple methods, ensuring smooth and transparent transactions',
                                        'path' =>
                                            'M130-119q-55.97 0-95.99-40.01Q-6-199.02-6-255v-437h136v437h683v136H130Zm193-192q-55.98 0-95.99-39.31Q187-389.63 187-447v-291q0-55.97 40.01-95.99Q267.02-874 323-874h507q55.97 0 95.99 40.01Q966-793.97 966-738v291q0 57.37-40.01 96.69Q885.97-311 830-311H323Zm70-121q0-34.65-24.97-59.33Q343.06-516 308-516v84h85Zm367 0h85v-84q-36 0-60.5 24.67Q760-466.65 760-432Zm-183.79-41q49.79 0 84.29-35 34.5-35 34.5-85t-34.71-85q-34.71-35-84.29-35-50.42 0-85.71 35Q455-643 455-593t35.71 85q35.7 35 85.5 35ZM308-669q35.06 0 60.03-24.97T393-754h-85v85Zm537 0v-85h-85q0 35 24.53 60 24.52 25 60.47 25Z',
                                    ],
                                    'Blacklist' => [
                                        'text' =>
                                            'manage a client blacklist to control vehicle access and enforce rental policies effectively',
                                        'path' =>
                                            'M480.15-32Q321-70 217.5-209.06 114-348.11 114-516.16v-274.82L480-928l366 137.02v274.38Q846-348 742.65-209 639.3-70 480.15-32ZM425-315h110q29 0 48.5-20.2T603-383v-98.63Q603-498 591.5-510T563-522v-40q0-34.35-24.33-58.17Q514.34-644 480.17-644t-58.67 23.83Q397-596.35 397-562v40q-17 0-28.5 12T357-482v99q0 27.6 19.5 47.8Q396-315 425-315Zm15-207v-40q0-16 11.5-28t28.5-12q17 0 28.5 12t11.5 28v40h-80Z',
                                    ],
                                    'Clients' => [
                                        'text' =>
                                            'manage customer data and rental history, offering insights to enhance personalized services',
                                        'path' =>
                                            'M13-116v-176q0-35.6 25.65-60.3Q64.3-377 98-377h146q20.21 0 34.11 7Q292-363 300-352q32 44 79.5 69.5T480.04-257q51.96 0 100.46-25.5Q629-308 663-352q6-11 19.59-18 13.6-7 34.41-7h146q35.6 0 60.8 24.7Q949-327.6 949-292v176H658v-128q-38 30-83 46.5T480.14-181q-47.8 0-93.97-16T304-243v127H13Zm466.88-214q-32.88 0-61.38-14.5T372-387q-22-29-48-43t-60-18q36-31 99.08-48T480-513q55.84 0 117.92 17T698-448q-34 4-61 18t-46 43q-19 27-48.58 42t-62.54 15ZM160-473q-47.67 0-81.33-34.25Q45-541.5 45-590.28 45-637 78.75-671t81.53-34Q209-705 243-670.8t34 80.8q0 48.67-34.2 82.83Q208.6-473 160-473Zm640 0q-47.67 0-81.33-34.25Q685-541.5 685-590.28 685-637 718.75-671t81.53-34Q849-705 883-670.8t34 80.8q0 48.67-34.2 82.83Q848.6-473 800-473ZM480-609q-47.67 0-81.33-34.25Q365-677.5 365-725.28q0-48.72 33.75-82.22t81.53-33.5Q529-841 563-807.3t34 82.3q0 47.67-34.2 81.83Q528.6-609 480-609Z',
                                    ],
                                    'Reminders' => [
                                        'text' =>
                                            'automate reminders for important tasks such as maintenance schedules',
                                        'path' =>
                                            'M480-35q-83 0-157-32t-129.5-87Q138-209 106-283T74-441q0-84 32-157.5t87.5-129Q249-783 323-815t157-32q84 0 158 32t129 87.5q55 55.5 87 129T886-441q0 84-32 158t-87 129q-55 55-129 87T480-35Zm102-225 76-76-125-124v-182H427v228l155 154ZM204-922l75 74L73-641l-74-75 205-206Zm552 0 206 206-74 75-207-207 75-74Z',
                                    ],
                                    'Vehicles' => [
                                        'text' =>
                                            'track and manage your fleet, ensuring each vehicle is well-maintained and available for rentals',
                                        'path' =>
                                            'M244-161v8q0 30.6-22.5 51.3Q199-81 166.7-81h-10.89Q125-81 102.5-103.29 80-125.58 80-156v-331.43L167-735q9.64-28.8 34.86-46.4Q227.08-799 258-799h444q30.92 0 56.14 17.6T793-735l87 247.57V-156q0 30.42-22.5 52.71T804.19-81H793.3q-32.3 0-54.8-20.7T716-153v-8H244Zm1-404h470l-36-105H281l-36 105Zm60 241q26 0 44-18.38t18-43.5q0-25.12-18-43.62-18-18.5-43.5-18.5T262-429.62q-18 18.38-18 43.5t18.13 43.62Q280.25-324 305-324Zm349.5 0q25.5 0 43.5-18.38t18-43.5q0-25.12-18.12-43.62Q679.75-448 655-448q-26 0-44 18.38t-18 43.5q0 25.12 18 43.62 18 18.5 43.5 18.5Z',
                                    ],
                                ];
                            @endphp
                            @foreach ($bollets as $head => $arr)
                                <li class="w-full items-start flex flex-wrap gap-4">
                                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-x-white">
                                        <svg class="block text-x-prime w-8 h-8 pointer-events-none"
                                            fill="currentcolor" viewBox="0 -960 960 960">
                                            <path d="{{ $arr['path'] }}" />
                                        </svg>
                                    </span>
                                    <div class="w-0 flex-1 flex flex-col mt-3">
                                        <span
                                            class="block flex-1 text-x-black text-base font-x-thin">{{ __($head) }}</span>
                                        <p class="text-base text-x-black">
                                            {{ ucfirst(__($arr['text'])) }}.
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div>
                            <img src="{{ asset('img/mobile.png') }}?v={{ env('APP_VERSION') }}"
                                alt="{{ env('APP_NAME') }} mobile image" class="block w-full" width="916"
                                height="516" loading="lazy" />
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-x-acent py-6 relative isolate overflow-hidden">
                <img src="{{ asset('img/svg/shapes.svg') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} shapes image"
                    class="block w-full h-full object-cover absolute inset-0 pointer-events-none z-[-100]" />
                <div class="p-4 container mx-auto flex flex-col gap-10">
                    <div class="flex flex-col gap-3">
                        <h3 class="font-x-huge text-start text-x-white text-2xl lg:text-5xl rtl:leading-[1.4]">
                            {{ ucwords(__('trusted by 13,643 businesses')) }} <br>
                            {{ ucwords(__('all around morocco')) }}
                        </h3>
                    </div>
                    <ul class="grid grid-rows-1 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-white text-start text-xl lg:text-3xl">
                                207,930.50 MAD
                            </h5>
                            <p class="text-x-white text-start text-lg">
                                {{ ucfirst(__('reservations paid')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-white text-start text-xl lg:text-3xl">
                                230,312,895
                            </h5>
                            <p class="text-x-white text-start text-lg">
                                {{ ucfirst(__('minutes tracked')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-white text-start text-xl lg:text-3xl">
                                4,000
                            </h5>
                            <p class="text-x-white text-start text-lg">
                                {{ ucfirst(__('reservations completed')) }}.
                            </p>
                        </li>
                        <li class="flex flex-col">
                            <h5 class="font-x-thin text-x-white text-start text-xl lg:text-3xl">
                                2,648
                            </h5>
                            <p class="text-x-white text-start text-lg">
                                {{ ucfirst(__('agencies signed')) }}.
                            </p>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="py-6 relative isolate overflow-hidden">
             <img src="{{ asset('img/svg/boxes.svg') }}?v={{ env('APP_VERSION') }}"
                    alt="{{ env('APP_NAME') }} boxes image"
                    class="block w-full h-full object-cover absolute inset-0 pointer-events-none z-[-100]" />
                <div class="p-4 container mx-auto flex flex-col gap-10">
                    <div class="flex flex-col gap-3 lg:w-10/12 lg:mx-auto">
                        <h3 class="font-x-thin text-center text-x-black text-xl lg:text-3xl">
                            {{ ucwords(__('frequently asked questions')) }}
                        </h3>
                        <p class="text-center text-x-black text-base">
                            {{ ucfirst(__('below you\'ll find answers to the most common questions about our services and how they can benefit your car rental business. If you don’t see your question here, feel free to contact our support team for further assistance')) }}
                        </p>
                    </div>
                    <ul class="grid grid-rows-1 grid-cols-1 lg:grid-cols-2 items-start gap-4">
                        <li>
                            <ul class="flex flex-col gap-4">
                                @php
                                    $bollets = [
                                        'what features does this platform offer' =>
                                            'our platform includes fleet management, reservation systems, customer management, payment processing, and analytics tools',
                                        'can i customize the software for my business' =>
                                            'yes, the platform allows customization to fit your brand, pricing models, and rental policies',
                                        'what support is available' =>
                                            'we provide 24/7 customer support and training resources',
                                        'how secure is the platform' =>
                                            'we use industry-standard encryption and data security measures to protect your business and customer data',
                                    ];
                                @endphp
                                @foreach ($bollets as $head => $text)
                                    <li
                                        class="tab-main tab-open w-full rounded-x-huge border bg-opacity-70 border-x-light bg-x-light">
                                        <div
                                            class="tab-header px-6 py-3 cursor-pointer flex flex-wrap gap-4 items-center">
                                            <h5 class="w-0 flex-1 text-x-black text-lg lg:text-xl">
                                                {{ ucwords(__($head)) }}?
                                            </h5>
                                            <svg class="tab-icon block text-x-black w-8 h-8 pointer-events-none"
                                                fill="currentcolor" viewBox="0 -960 960 960">
                                                <path d="M480-352 263-567h434L480-352Z"></path>
                                            </svg>
                                        </div>
                                        <div class="tab-content overflow-hidden transition-all duration-150"
                                            style="max-height: 0px">
                                            <p class="text-x-black text-base p-6 border-t border-x-prime">
                                                {{ ucfirst(__($text)) }}
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <ul class="flex flex-col gap-4">
                                @php
                                    $bollets = [
                                        'do you offer training for new users' =>
                                            'yes, we provide onboarding and training materials, as well as live support during setup',
                                        'is there a mobile app for managing rentals' =>
                                            'yes, we offer a mobile app for managing bookings and fleet operations on the go',
                                        'how do i access customer reports' =>
                                            'detailed customer and reservation reports are available through the analytics dashboard',
                                        'what are the system requirements' =>
                                            'the platform is cloud-based, accessible via any modern web browser without special hardware requirements',
                                    ];
                                @endphp
                                @foreach ($bollets as $head => $text)
                                    <li
                                        class="tab-main tab-open w-full rounded-x-huge border bg-opacity-70 border-x-light bg-x-light">
                                        <div
                                            class="tab-header px-6 py-3 cursor-pointer flex flex-wrap gap-4 items-center">
                                            <h5 class="w-0 flex-1 text-x-black text-lg lg:text-xl">
                                                {{ ucwords(__($head)) }}?
                                            </h5>
                                            <svg class="tab-icon block text-x-black w-8 h-8 pointer-events-none"
                                                fill="currentcolor" viewBox="0 -960 960 960">
                                                <path d="M480-352 263-567h434L480-352Z"></path>
                                            </svg>
                                        </div>
                                        <div class="tab-content overflow-hidden transition-all duration-150"
                                            style="max-height: 0px">
                                            <p class="text-x-black text-base p-6 border-t border-x-prime">
                                                {{ ucfirst(__($text)) }}
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
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
                content = tab.querySelector(".tab-content"),
                icon = tab.querySelector(".tab-icon");

            header.addEventListener("click", e => {
                tabs.forEach(_tab => {
                    if (tab === _tab) return;
                    _tab.classList.remove("tab-open", "bg-opacity-20", "border-x-prime",
                        "bg-x-prime");
                    _tab.classList.add("bg-opacity-70", "border-x-light", "bg-x-light");
                    _tab.querySelector(".tab-icon").classList.remove("rotate-180");
                    _tab.querySelector(".tab-content").style.maxHeight = "0px";
                });
                setTimeout(() => {
                    if (tab.classList.contains("tab-open")) {
                        tab.classList.remove("tab-open", "bg-opacity-20", "border-x-prime",
                            "bg-x-prime");
                        tab.classList.add("bg-opacity-70", "border-x-light", "bg-x-light");
                        icon.classList.remove("rotate-180");
                        content.style.maxHeight = "0px";
                    } else {
                        tab.classList.add("tab-open", "bg-opacity-20", "border-x-prime",
                            "bg-x-prime");
                        tab.classList.remove("bg-opacity-70", "border-x-light", "bg-x-light");
                        icon.classList.add("rotate-180");
                        content.style.maxHeight = "500px";
                    }
                }, 500);
            });
        });
    </script>
</body>

</html>
