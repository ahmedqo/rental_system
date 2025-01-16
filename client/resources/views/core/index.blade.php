@extends('shared.core.base')
@section('title', __('Dashboard'))

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'scene' => route('views.tickets.scene', 'XXX'),
        'filter' => route('actions.tickets.search'),
        'entire' => route('actions.tickets.filter'),
        'search' => route('actions.core.popular'),
        'chart' => route('actions.core.chart'),
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
        <div class="bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-popular" header="{{ __('Popular vehicles') }}"></neo-datavisualizer>
        </div>
        <div class="bg-x-white rounded-x-thin shadow-x-core">
            <neo-datavisualizer id="data-tickets" search header=" {{ __('Tickets list') }}">
                <neo-tooltip slot="start" label="{{ __('Show all tickets') }}">
                    <neo-switch id="filter" active></neo-switch>
                </neo-tooltip>
                <neo-tooltip slot="end" label="{{ __('Open ticket') }}">
                    <a href="{{ route('views.tickets.store') }}"
                        class="flex w-8 h-8 items-center justify-center text-x-white outline-none rounded-x-thin bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M479.825-185q-18.45 0-31.637-12.625Q435-210.25 435-231v-203H230q-18.375 0-31.688-13.56Q185-461.119 185-479.86q0-20.14 13.312-32.64Q211.625-525 230-525h205v-205q0-19.775 13.358-32.388Q461.716-775 480.158-775t32.142 12.612Q526-749.775 526-730v205h204q18.8 0 32.4 12.675 13.6 12.676 13.6 32.316 0 19.641-13.6 32.825Q748.8-434 730-434H526v203q0 20.75-13.65 33.375Q498.699-185 479.825-185Z" />
                        </svg>
                    </a>
                </neo-tooltip>
            </neo-datavisualizer>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/core/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
