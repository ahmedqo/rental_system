@extends('shared.core.base')
@section('title', __('Preview vehicle') . ' #' . $data->id)

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'filterReservations' => route('actions.vehicles.reservations.search', $data->id),
        'entireReservations' => route('actions.vehicles.reservations.filter', $data->id),
        'filterRecoveries' => route('actions.vehicles.recoveries.search', $data->id),
        'entireRecoveries' => route('actions.vehicles.recoveries.filter', $data->id),
        'filterPayments' => route('actions.vehicles.payments.search', $data->id),
        'entirePayments' => route('actions.vehicles.payments.filter', $data->id),
        'entireCharges' => route('actions.vehicles.charges.search', $data->id),
    
        'patchCharge' => route('views.charges.patch', 'XXX'),
        'clearCharge' => route('actions.charges.clear', 'XXX'),
    
        'patchReservation' => route('views.reservations.patch', 'XXX'),
        'printReservation' => route('views.reservations.print', 'XXX'),
    
        'patchPayment' => route('views.payments.patch', 'XXX'),
    
        'patchRecovery' => route('views.recoveries.patch', 'XXX'),
    
        'csrf' => csrf_token(),
        'chart' => route('actions.vehicles.chart', $data->id),
    ]) !!}' />
    <meta name="count" content="{!! json_encode([(float) $vals->paid > 0 ? $vals->paid - $vals->charges : 0, (float) $vals->charges]) !!}" />
    <meta name="rtl" content="{{ Core::lang('ar') }}" />
@endsection

@php
    $currency = Core::preference() ? Core::preference('currency') : '';
    $mileage = Core::company('mileage_per_day');
@endphp

@section('content')
    <div class="w-full items-start grid grid-rows-1 grid-cols-1 gap-6">
        <nav data-tabs
            class="w-[calc(100%+2rem)] -mt-8 -mx-4 p-2 lg:w-max lg:max-w-full lg:mt-0 lg:mx-auto lg:rounded-x-thin bg-x-white shadow-x-core overflow-auto">
            <ul class="w-max flex gap-2">
                <li>
                    <a data-for="overview"
                        class="cursor-pointer w-max flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none rounded-x-thin hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent bg-x-prime text-x-white">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M417-339q25 25 62.5 23.5T537-343l257-370-371 257q-26 20-28 56.5t22 60.5ZM202-117q-32 0-61-15t-44-44q-30-51-45.5-107.5T36-399q0-92 35-173t95.5-141q60.5-60 141-95T480-843q92 0 172.5 34t141 93.5Q854-656 889-576t35 171q0 61-15 119t-45 110q-17 29-45 44t-60 15H202Z" />
                        </svg>
                        <span class="block flex-1 text-base">{{ __('Overview') }}</span>
                    </a>
                </li>
                <li>
                    <a data-for="reservation"
                        class="cursor-pointer w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none rounded-x-thin hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent text-x-black">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M482.77-98Q434-135 378-160q-56-25-117.59-25Q221-185 184-174t-71 29q-37 19-71.5-1T7-206v-480q0-26.06 11-48.33Q29-756.61 52-769q47.63-22 99.32-32.5Q203-812 257.24-812q60.26 0 116.51 15Q430-782 480-748.53V-229q51-31 106-50t114-19q36 0 71 7t69 20v-524q17.52 6 34.52 13 17 7 35.48 13 23 10.39 33 33.67 10 23.27 10 49.33v496q0 35-34.5 49.5T847-145q-34-18-71-29t-76.41-11q-60.59 0-114.82 25-54.23 25-102 62ZM560-332v-417l200-208v437L560-332Z" />
                        </svg>
                        <span class="block flex-1 text-base">{{ __('Reservations') }}</span>
                    </a>
                </li>
                <li>
                    <a data-for="recovery"
                        class="cursor-pointer w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none rounded-x-thin hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent text-x-black">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="m481-296 78-79-51-50h158v-113H508l51-51-78-79-186 186 186 186ZM210-76q-56.98 0-96.49-40.01T74-212v-540q0-55.97 39.51-95.99Q153.02-888 210-888h125q24-38 62-59.5t83-21.5q45 0 83 21.5t62 59.5h125q56.97 0 96.49 40.01Q886-807.97 886-752v540q0 55.98-39.51 95.99Q806.97-76 750-76H210Zm270-712q16.47 0 27.23-10.77Q518-809.53 518-826t-10.77-27.23Q496.47-864 480-864t-27.23 10.77Q442-842.47 442-826t10.77 27.23Q463.53-788 480-788Z" />
                        </svg>
                        <span class="block flex-1 text-base">{{ __('Recoveries') }}</span>
                    </a>
                </li>
                <li>
                    <a data-for="payment"
                        class="cursor-pointer w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none rounded-x-thin hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent text-x-black">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M130-119q-55.97 0-95.99-40.01Q-6-199.02-6-255v-437h136v437h683v136H130Zm193-192q-55.98 0-95.99-39.31Q187-389.63 187-447v-291q0-55.97 40.01-95.99Q267.02-874 323-874h507q55.97 0 95.99 40.01Q966-793.97 966-738v291q0 57.37-40.01 96.69Q885.97-311 830-311H323Zm70-121q0-34.65-24.97-59.33Q343.06-516 308-516v84h85Zm367 0h85v-84q-36 0-60.5 24.67Q760-466.65 760-432Zm-183.79-41q49.79 0 84.29-35 34.5-35 34.5-85t-34.71-85q-34.71-35-84.29-35-50.42 0-85.71 35Q455-643 455-593t35.71 85q35.7 35 85.5 35ZM308-669q35.06 0 60.03-24.97T393-754h-85v85Zm537 0v-85h-85q0 35 24.53 60 24.52 25 60.47 25Z" />
                        </svg>
                        <span class="block flex-1 text-base">{{ __('Payments') }}</span>
                    </a>
                </li>
                <li>
                    <a data-for="charge"
                        class="cursor-pointer w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none rounded-x-thin hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent text-x-black">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M417-205h111v-40h40q23.25 0 39.13-16.38Q623-277.75 623-301v-139q0-23.25-15.87-39.13Q591.25-495 568-495H448v-29h175v-111h-80v-40H432v40h-40q-23.25 0-39.12 16.37Q337-602.25 337-579v139q0 23.25 15.88 39.12Q368.75-385 392-385h120v29H337v111h80v40ZM250-34q-55.73 0-95.86-39.64Q114-113.28 114-170v-620q0-56.72 40.14-96.36Q194.27-926 250-926h329l267 267v489q0 56.72-40.14 96.36T710-34H250Z" />
                        </svg>
                        <span class="block flex-1 text-base">{{ __('Charges') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div data-tab="overview" class="w-full grid grid-rows-1 grid-cols-1 gap-6">
            @if ($reminders->count() || $vals->ended)
                <ul class="w-full flex flex-col gap-1">
                    @if ($vals->ended)
                        <li
                            class="flex flex-wrap items-center gap-4 bg-red-500 text-x-white p-4 text-base font-x-thin rounded-x-thin shadow-x-core">
                            <svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M480-40q-26 0-50.94-10.74Q404.12-61.48 384-80L80-384q-18.52-20.12-29.26-45.06Q40-454 40-480q0-26 10.59-51.12Q61.17-556.24 80-576l304-304q20.12-20.48 45.06-30.24Q454-920 480-920q26 0 51.12 9.91Q556.24-900.17 576-880l304 304q20.17 19.76 30.09 44.88Q920-506 920-480q0 26-9.76 50.94Q900.48-404.12 880-384L576-80q-19.76 18.83-44.88 29.41Q506-40 480-40Zm-60-382h120v-250H420v250Zm60 160q25.38 0 42.69-17.81Q540-297.63 540-322q0-25.38-17.31-42.69T480-382q-25.37 0-42.69 17.31Q420-347.38 420-322q0 24.37 17.31 42.19Q454.63-262 480-262Z" />
                            </svg>
                            <span class="w-0 flex-1">
                                {{ __('This vehicle has :num pending reservations where the dropoff date has passed', ['num' => $vals->ended]) }}
                            </span>
                        </li>
                    @endif
                    @foreach ($reminders as $row)
                        <li
                            class="flex flex-wrap items-center gap-4 bg-yellow-500 text-x-white p-4 text-base font-x-thin rounded-x-thin shadow-x-core">
                            <svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M739-423v-114h210v114H739Zm80 299L651-249l69-92 167 125-68 92Zm-99-495-69-92 168-125 68 92-167 125ZM129-161v-161h-6q-48-6-80-42.5T11-450v-60q0-52 37.5-90t90.5-38h131l247-149v614L270-322h-5v161H129Zm444-149v-340q42 28 67 73t25 97q0 52-25 97t-67 73Z" />
                            </svg>
                            <span class="w-0 flex-1">
                                "{{ ucfirst(__($row->consumable_name)) }}" {{ __('is due on') }}
                                "{{ \Carbon\Carbon::parse($row->view_issued_at)->translatedFormat(Core::preference() ? Core::formatsList(Core::preference('date_format'), 1) : 'Y-m-d') }}"
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if ($data->loan_amount > 0)
                <div
                    class="p-4 gap-4 lg:gap-10 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader z-[1] w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="block w-10 aspect-square pointer-events-none text-blue-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M153-266v-274h121v274H153Zm267 0v-274h120v274H420ZM28-81v-136h904v136H28Zm658-185v-274h121v274H686ZM28-590v-146l452-228 452 228v146H28Z" />
                    </svg>
                    <div class="flex w-full flex-1 flex-col gap-2">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Loan') }}
                        </h2>
                        @php
                            $size = ($data->paid_amount / $data->loan_amount) * 100;
                        @endphp
                        <div class="w-full h-4 bg-x-light rounded-full flex flex-wrap">
                            <div class="h-full bg-x-prime rounded-full relative" style="width: {{ $size }}%">
                                <neo-tooltip class="w-full h-full absolute inset-0"
                                    label="{{ Core::formatNumber($data->paid_amount) }} {{ $currency }}">
                                </neo-tooltip>
                            </div>
                            <div class="h-full rounded-full relative" style="width: {{ 100 - $size }}%">
                                <neo-tooltip class="w-full h-full absolute inset-0"
                                    label="{{ Core::formatNumber($data->due_amount) }} {{ $currency }}">
                                </neo-tooltip>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <ul class="container mx-auto grid gap-6 grid-cols-2 grid-rows-1 lg:grid-cols-12 lg:grid-flow-row">
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="block w-10 aspect-square pointer-events-none text-green-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M222-340v-56H121v-121h202v-40H180q-24.28 0-41.64-16.8T121-615.94V-782q0-23.85 17.36-40.42Q155.72-839 180-839h42v-55h121v55h101v121H242v40h145q23.85 0 40.42 16.86Q444-644.27 444-620v166q0 23.85-16.58 40.92Q410.85-396 387-396h-44v56H222ZM573-75 380-269l91-90 102 102 216-214 90 90L573-75Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Payments') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ Core::formatNumber($vals->paid) }}
                            {{ $currency }}
                        </p>
                    </div>
                </li>
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="lock w-10 aspect-square pointer-events-none text-yellow-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M479 5Q362 5 265-44.5T103-176v88H-17v-300h300v120h-98q48 68 125 110t169 42q72 0 137-27t115-74.5Q781-265 811.5-330T844-472h121q-2 102-42 189T816.5-132Q750-68 663-31.5T479 5Zm-47-200v-46q-44-10-78-44t-45-92l88-34q9 46 32.5 66.5T486-324q34 0 51.5-13t17.5-40q0-25-22-40.5T461-450q-71-24-102.5-57.5T327-593q0-42 26.5-78t80.5-50v-44h94v44q40 6 68.5 34t40.5 73l-86 35q-7-27-25.5-43T476-638q-25 0-40 11t-15 29q0 23 22 37.5t81 34.5q75 25 100 64.5t25 84.5q0 33-10 56.5T612-281q-17 16-39 26t-47 16v44h-94ZM-5-488q0-97 38-183.5t104-152Q203-889 291.5-927T480-965q114 0 214 49.5T856-784v-88h121v300H677v-120h98q-53-73-132-112.5T480-844q-72 0-137.5 27T227-742.5Q177-695 147-630t-32 142H-5Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Creances') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ Core::formatNumber($vals->rest) }}
                            {{ $currency }}
                        </p>
                    </div>
                </li>
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="lock w-10 aspect-square pointer-events-none text-red-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M509-75v-136h147L509-357v-192l242 242v-146h136v378H509ZM210-260v-47H74v-136h242v-65H204q-53.95 0-91.97-37.97Q74-583.94 74-639v-77q0-54 38.03-92 38.02-38 91.97-38h6v-46h105v46h137v136H210v66h111q55.06 0 93.03 37.5T452-514v77q0 53.95-37.97 91.98Q376.06-307 321-307h-6v47H210Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Charges') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ Core::formatNumber($vals->charges) }}
                            {{ $currency }}
                        </p>
                    </div>
                </li>
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="lock w-10 aspect-square pointer-events-none text-teal-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M482.77-98Q434-135 378-160q-56-25-117.59-25Q221-185 184-174t-71 29q-37 19-71.5-1T7-206v-480q0-26.06 11-48.33Q29-756.61 52-769q47.63-22 99.32-32.5Q203-812 257.24-812q60.26 0 116.51 15Q430-782 480-748.53V-229q51-31 106-50t114-19q36 0 71 7t69 20v-524q17.52 6 34.52 13 17 7 35.48 13 23 10.39 33 33.67 10 23.27 10 49.33v496q0 35-34.5 49.5T847-145q-34-18-71-29t-76.41-11q-60.59 0-114.82 25-54.23 25-102 62ZM560-332v-417l200-208v437L560-332Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Reservations') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ $vals->count }}
                        </p>
                    </div>
                </li>
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="lock w-10 aspect-square pointer-events-none text-fuchsia-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M686 11 505-170l95-95 85 85 170-171 95 97L686 11ZM333-216l-95-95 64-64-64-64 95-95 64 64 64-64 95 95-64 64 64 64-95 95-64-64-64 64ZM210-34q-57.12 0-96.56-40.14Q74-114.28 74-170v-541q0-57.13 39.44-96.56Q152.88-847 210-847h15v-79h113v79h284v-79h113v79h15q57.13 0 96.56 39.44Q886-768.13 886-711v215L750-358v-210H210v398h181L526-34H210Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Period') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ $vals->period ?? '0' }}
                            {{ __('Days') }}
                        </p>
                    </div>
                </li>
                <li
                    class="lg:col-span-3 p-4 gap-4 flex flex-col flex-wrap items-center lg:flex-row relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <svg class="lock w-10 aspect-square pointer-events-none text-violet-500" fill="currentcolor"
                        viewBox="0 -960 960 960">
                        <path
                            d="M479.77 12Q303 12 191.5-44.11 80-100.23 80-189q0-43.06 30-80.53T196-335l94 103q-18 6-39 17t-36 24q21.49 27.2 101.28 47.1Q396.07-124 481.25-124q86.02 0 164.81-20.3T746-191q-16-14-37.81-24.86Q686.38-226.71 667-233l95-104q57 28 87.5 66.5t30.5 80.77q0 89.63-111.73 145.68Q656.54 12 479.77 12ZM481-154Q315.76-271 235.38-382.44T155-600.74q0-80.61 29.83-141.33 29.83-60.71 76.62-101.57 46.79-40.85 104.54-61.61Q423.74-926 480.31-926q56.9 0 115.53 20.93 58.63 20.92 104.87 61.77t75.77 101.49Q806-681.17 806-601.08q0 107.38-80.63 218.73Q644.73-271 481-154Zm.12-360q38.88 0 66.38-27.56 27.5-27.57 27.5-65.16 0-38.87-27.44-66.58Q520.13-701 481.5-701q-39.04 0-67.27 27.7Q386-645.59 386-607.22q0 38.38 28.12 65.8 28.12 27.42 67 27.42Z" />
                    </svg>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-center lg:text-end text-lg text-x-black font-x-thin">
                            {{ __('Mileage') }}
                        </h2>
                        <p class="text-center lg:text-end text-base text-gray-800">
                            {{ ceil($vals->period * $mileage) }}
                            {{ __('Km') }}
                        </p>
                    </div>
                </li>
                <li
                    class="flex flex-col col-span-2 lg:col-span-3 lg:row-span-2 relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="donut-loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center z-10">
                        <neo-loader></neo-loader>
                    </div>
                    <div class="py-3 px-6 border-b border-x-shade">
                        <h2 class="text-x-black font-x-thin text-lg">
                            {{ __('Profit rate') }}
                        </h2>
                    </div>
                    <div
                        class="my-auto mx-auto lg:w-10/12 flex items-center w-full rounded-x-thin bg-x-white p-4 aspect-square relative">
                        <div class="w-full h-full absolute inset-0 flex items-center justify-center pointer-events-none">
                            <h1 class="text-lg font-x-thin text-x-black pointer-events-auto">
                                {{ !+$vals->paid || +$vals->paid < 0 ? (!$vals->charges ? '0.00' : '-100.00') : Core::formatNumber(100 - ($vals->charges / ($vals->paid > 0 ? $vals->paid : 1)) * 100) }}%
                            </h1>
                        </div>
                        <canvas id="donut"></canvas>
                    </div>
                </li>
                <li
                    class="flex flex-col col-span-2 lg:col-span-9 lg:row-span-4 lg:row-start-2 lg:col-start-1 relative bg-x-white rounded-x-thin shadow-x-core">
                    <div
                        class="chart-loader w-full h-full rounded-x-thin bg-x-white absolute inset-0 flex items-center justify-center">
                        <neo-loader></neo-loader>
                    </div>
                    <div class="py-3 px-6 border-b border-x-shade">
                        <h2 class="text-x-black font-x-thin text-lg">
                            {{ __('Income visualization') }}
                        </h2>
                    </div>
                    <div class="flex-1 rounded-x-thin bg-x-white p-4 flex items-center justify-center">
                        <canvas id="chart"></canvas>
                    </div>
                </li>
            </ul>
        </div>
        <div data-tab="reservation" class="hidden bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-reservations" search header=" {{ __('Reservations list') }}">
                <neo-tooltip slot="start" label="{{ __('Show all reservations') }}">
                    <neo-switch id="filter-reservations" active></neo-switch>
                </neo-tooltip>
            </neo-datavisualizer>
        </div>
        <div data-tab="recovery" class="hidden bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-recoveries" search header=" {{ __('Recoveries list') }}">
                <neo-tooltip slot="start" label="{{ __('Show all recoveries') }}">
                    <neo-switch id="filter-recoveries" active></neo-switch>
                </neo-tooltip>
            </neo-datavisualizer>
        </div>
        <div data-tab="payment" class="hidden bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-payments" search header=" {{ __('Payments list') }}">
                <neo-tooltip slot="start" label="{{ __('Show all payments') }}">
                    <neo-switch id="filter-payments" active></neo-switch>
                </neo-tooltip>
            </neo-datavisualizer>
        </div>
        <div data-tab="charge" class="hidden bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-charges" search header=" {{ __('Charges list') }}"></neo-datavisualizer>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/vehicle/scene.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
