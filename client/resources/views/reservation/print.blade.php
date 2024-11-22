@extends('shared.core.base')
@section('title', __('Preview reservation') . ' #' . $data->id)

@section('meta')
    <meta name="condition" content='{{ $data->condition }}'>
@endsection

@php
    $format_middle = Core::setting() ? Core::formatsList(Core::setting('date_format'), 1) : 'Y-m-d';
    $format_first = $format_middle . ' H:i';
    $format_last = Core::setting() ? Core::formatsList(Core::setting('date_format'), 1) : 'm/d/Y';
@endphp

@section('content')
    <div class="bg-x-white rounded-x-thin shadow-x-core">
        <div class="py-3 px-6 border-b border-x-shade flex items-center justify-between gap-4">
            <label class="text-x-black font-x-thin text-xl">
                #{{ $data->reference }}
            </label>
            <button id="print" title="{{ __('Print') }}"
                class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M766-724H194v-165h572v165Zm-76 321q25 0 42-16.81 17-16.82 17-42.19 0-25-16.81-42.5T690-522q-25 0-42.5 17.5T630-462q0 25 17.5 42t42.5 17Zm-60 220v-64H330v64h300ZM766-54H194v-180H28v-280q0-68 47.04-116T189-678h582q68.17 0 114.59 48Q932-582 932-514v280H766v180Z" />
                </svg>
            </button>
        </div>
        <div class="p-6 pt-8">
            <div class="w-full grid grid-rows-1 grid-cols-1 gap-6">
                <div class="w-full p-4 border border-x-shade relative">
                    <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                        <span class="block w-max text-base font-x-thin bg-x-white border border-x-shade px-2">
                            {{ __('Vehicle Information') }}
                        </span>
                    </div>
                    <div class="w-full flex flex-col gap-2 md:gap-0">
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Brand') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ $data->Vehicle ? ucfirst(__($data->Vehicle->brand)) : 'N/A' }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Registration number') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ $data->Vehicle ? strtoupper($data->Vehicle->registration_number) : 'N/A' }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Pick-up Location') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ ($data->pickup_location ? ucfirst($data->pickup_location) : $data->Owner) ? ucfirst($data->Owner->address) . ' ' . ucfirst(__($data->Owner->city)) . ' ' . $data->Owner->zipcode : '' }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Drop-off Location') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ ($data->dropoff_location ? ucfirst($data->dropoff_location) : $data->Owner) ? ucfirst($data->Owner->address) . ' ' . ucfirst(__($data->Owner->city)) . ' ' . $data->Owner->zipcode : '' }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Date Hour') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ \Carbon\Carbon::parse($data->pickup_date)->translatedFormat($format_first) }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Date Hour') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ \Carbon\Carbon::parse($data->dropoff_date)->translatedFormat($format_first) }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-wrap items-center">
                                <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                    {{ __('Rental Duration') }}
                                </div>
                                <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                            </div>
                            <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                {{ $data->rental_period_days }} {{ __('Days') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex border border-x-shade flex-col lg:flex-row">
                    <div
                        class="w-full p-4 border-b lg:border-b-0 lg:border-e border-b-shade lg:border-b-transparent lg:border-e-x-shade relative">
                        <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                            <span class="block w-max text-base font-x-thin bg-x-white border border-x-shade px-2">
                                {{ __('Renter Driver') }}
                            </span>
                        </div>
                        <div class="w-full flex flex-col gap-2 md:gap-0">
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('First Name') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? ucfirst($data->Client->first_name) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Last Name') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? strtoupper($data->Client->last_name) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Brith Date') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->birth_date)->translatedFormat($format_middle) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('License number') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->license_number : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Delivered On') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->license_issued_at)->translatedFormat($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-sm text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->Client ? ucfirst(__(strtolower($data->Client->license_issued_in))) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ $data->Client ? ucfirst(__($data->Client->identity_type)) : 'N/A' }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->identity_number : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Delivered On') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->identity_issued_at)->translatedFormat($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-sm text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->Client ? ucfirst(__(strtolower($data->Client->identity_issued_in))) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Phone') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->phone : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Address') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? ucfirst($data->Client->address) . ' ' . ucfirst(__($data->Client->city)) . ', ' . $data->Client->zipcode : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full p-4 relative">
                        <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3 z-20">
                            <span class="block w-max text-base font-x-thin bg-x-white border border-x-shade px-2">
                                {{ __('Second Driver') }}
                            </span>
                        </div>
                        @if (!$data->SClient)
                            <img src="{{ asset('img/mark.png') }}?v={{ env('APP_VERSION') }}"
                                class="w-full h-full absolute inset-0 z-10 object-center invert-[.9]" />
                        @endif
                        <div class="w-full flex flex-col gap-2 md:gap-0">
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('First Name') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? ucfirst($data->SClient->first_name) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Last Name') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? strtoupper($data->SClient->last_name) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Brith Date') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->birth_date)->translatedFormat($format_middle) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('License number') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->license_number : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Delivered On') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->license_issued_at)->translatedFormat($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-sm text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->SClient ? ucfirst(__(strtolower($data->SClient->license_issued_in))) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ $data->SClient ? ucfirst(__($data->SClient->identity_type)) : 'N/A' }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->identity_number : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Delivered On') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->identity_issued_at)->translatedFormat($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-sm text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->SClient ? ucfirst(__(strtolower($data->SClient->identity_issued_in))) : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Phone') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->phone : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Address') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? ucfirst($data->SClient->address) . ' ' . ucfirst(__($data->SClient->city)) . ', ' . $data->SClient->zipcode : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full border border-x-shade relative">
                    <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                        <span class="block w-max text-base font-x-thin bg-x-white border border-x-shade px-2">
                            {{ __('Vehicle Condition') }}
                        </span>
                    </div>
                    <div class="w-full flex items-end p-4 border-b border-b-shade flex-col lg:flex-row gap-2 lg:gap-0">
                        <div class="w-full flex flex-col gap-2 md:gap-0">
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Fuel Level') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->fuel_level }} %
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Starting Mileage') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->mileage }} {{ __('Km') }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Advance') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Payment ? Core::formatNumber($data->Payment->paid) : '?' }}
                                    {{ Core::setting() ? Core::setting('currency') : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-2 md:gap-0">
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Return Mileage') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Recovery ? $data->Recovery->mileage : '?' }} {{ __('Km') }}
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="flex flex-wrap items-center">
                                    <div class="w-max md:w-[180px] pe-1 text-sm text-x-black font-x-thin">
                                        {{ __('Creance') }}
                                    </div>
                                    <div class="w-max md:w-4 text-sm text-x-black font-x-thin">:</div>
                                </div>
                                <div class="ps-2 md:ps-0 text-sm text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Payment ? Core::formatNumber($data->Payment->rest) : '?' }}
                                    {{ Core::setting() ? Core::setting('currency') : '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col lg:flex-row justify-center p-4 gap-4">
                        <div class="w-full lg:w-1/3 relative">
                            <img id="img" src="{{ asset('img/state.png') }}" class="block w-full" />
                            <svg viewBox="0 0 819.000000 476.000000" class="block w-full h-full absolute inset-0">
                                <g transform="translate(0.000000,476.000000) scale(0.100000,-0.100000)" fill="transparent"
                                    stroke="none">
                                    @foreach (Core::pathList() as $key => $path)
                                        <path id="part-{{ $key + 1 * 100 }}" class="path cursor-pointer"
                                            d="{{ $path }}" />
                                    @endforeach
                                </g>
                            </svg>
                        </div>
                        <ul class="w-full lg:w-1/3 flex justify-center items-center flex-wrap gap-2 my-auto">
                            @foreach (collect(json_decode($data->condition)) as $i)
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span class="block w-3 h-3 rounded-full"
                                        style="background:{{ $i->color }}"></span>
                                    <span class="block text-sm">
                                        {{ ucfirst(__($i->name)) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="w-full p-4 flex flex-col gap-2 border border-x-shade -mt-3">
                    <p class="text-x-black text-sm font-x-thin text-center">
                        {{ __('I, the undersigned, tenant of the vehicle whose information is cited above, acknowledge having read the general rental conditions on the reverse side and accept the rates mentioned above.') }}
                    </p>
                    <div class="w-full flex flex-col lg:flex-row gap-4 lg:px-10">
                        <div class="flex w-full p-2 border border-x-shade lg:me-8 min-h-[3.5rem]">
                            <span class="block mx-auto text-x-black font-x-thin text-sm text-center">
                                {{ Core::company() ? ucfirst(Core::company('name')) : '' }}
                            </span>
                        </div>
                        <div class="flex w-full p-2 border border-x-shade min-h-[3.5rem]">
                            <span class="block mx-auto text-x-black font-x-thin text-sm text-center">
                                {{ $data->Client ? strtoupper($data->Client->last_name) . ' ' . ucfirst($data->Client->first_name) : __('Renter') . ' 1' }}
                            </span>
                        </div>
                        <div class="flex w-full p-2 border border-x-shade min-h-[3.5rem] relative">
                            @if (!$data->SClient)
                                <img src="{{ asset('img/mark.png') }}?v={{ env('APP_VERSION') }}"
                                    class="w-full h-full absolute inset-0 z-10 object-center invert-[.9]" />
                            @endif
                            <span class="block mx-auto text-x-black font-x-thin text-sm text-center">
                                {{ $data->SClient ? strtoupper($data->SClient->last_name) . ' ' . ucfirst($data->SClient->first_name) : __('Renter') . ' 2' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="w-full justify-center lg:justify-start lg:w-1/2 lg:ms-auto flex gap-2">
                            <span class="text-x-black text-sm font-x-huge">
                                {{ __('Contract Valid Until') }} <span class="text-x-black text-opacity-70">
                                    {{ \Carbon\Carbon::parse($data->dropoff_date)->format($format_middle) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $format_middle = 'Y-m-d';
        $format_last = 'm/d/Y';
        $format_first = $format_middle . ' H:i';
    @endphp
    <neo-printer margin="0mm 0mm 0mm 0mm">
        <neo-paper class="flex flex-col h-[295.5mm] relative">
            <div class="px-4 pt-4">
                <neo-head
                    class="w-full flex flex-wrap items-center justify-between gap-4 p-2 border border-x-x-black border-y-x-black">
                    @if (Core::company())
                        <h1 class="text-2xl text-x-black font-x-huge">
                            {{ strtoupper(Core::company('name')) }}
                        </h1>
                    @endif
                    <img id="logo" class="block h-[58px]"
                        src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}" />
                </neo-head>
            </div>
            <div class="w-full flex flex-col gap-6 mt-10 mb-auto px-4">
                <div>
                    <div class="w-1/3 ms-auto flex gap-2 -mb-4 -mt-2">
                        <span class="text-x-black text-base font-x-thin">
                            {{ __('Contract N') }}:
                        </span>
                        <span class="text-base text-x-black text-opacity-70 font-x-thin">
                            {{ $data->reference }}
                        </span>
                    </div>
                </div>
                <div class="w-full p-2 border border-x-x-black border-y-x-black relative">
                    <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                        <span
                            class="block w-max text-base font-x-thin bg-x-white border border-x-x-black border-y-x-black px-2">
                            {{ __('Vehicle Information') }}
                        </span>
                    </div>
                    <table class="w-full mt-2">
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Brand') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ $data->Vehicle ? ucfirst(__($data->Vehicle->brand)) : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Registration number') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ $data->Vehicle ? strtoupper($data->Vehicle->registration_number) : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Pick-up Location') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ ($data->pickup_location ? ucfirst($data->pickup_location) : Core::company()) ? ucfirst(Core::company('address')) . ' ' . ucfirst(__(Core::company('city'))) . ' ' . Core::company('zipcode') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Drop-off Location') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ ($data->dropoff_location ? ucfirst($data->dropoff_location) : Core::company()) ? ucfirst(Core::company('address')) . ' ' . ucfirst(__(Core::company('city'))) . ' ' . Core::company('zipcode') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Date Hour') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ \Carbon\Carbon::parse($data->pickup_date)->format($format_first) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Date Hour') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ \Carbon\Carbon::parse($data->dropoff_date)->format($format_first) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[160px] pe-1 text-xs text-x-black font-x-thin">
                                {{ __('Rental Duration') }}
                            </td>
                            <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                            <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ $data->rental_period_days }} {{ __('Days') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="w-full flex border border-x-x-black border-y-x-black">
                    <div class="w-full p-2 border-e border-e-black relative">
                        <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                            <span
                                class="block w-max text-base font-x-thin bg-x-white border border-x-x-black border-y-x-black px-2">
                                {{ __('Renter Driver') }}
                            </span>
                        </div>
                        <table class="w-full mt-2">
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('First Name') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? ucfirst($data->Client->first_name) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Last Name') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? strtoupper($data->Client->last_name) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Brith Date') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->birth_date)->format($format_middle) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('License number') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->license_number : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Delivered On') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->license_issued_at)->format($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-xs text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->Client ? ucfirst(__(strtolower($data->Client->license_issued_in))) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ $data->Client ? ucfirst(__($data->Client->identity_type)) : 'N/A' }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->identity_number : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Delivered On') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? \Carbon\Carbon::parse($data->Client->identity_issued_at)->format($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-xs text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->Client ? ucfirst(__(strtolower($data->Client->identity_issued_in))) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Phone') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? $data->Client->phone : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Address') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Client ? ucfirst($data->Client->address) . ' ' . ucfirst(__($data->Client->city)) . ', ' . $data->Client->zipcode : 'N/A' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="w-full p-2 relative">
                        <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3 z-20">
                            <span
                                class="block w-max text-base font-x-thin bg-x-white border border-x-x-black border-y-x-black px-2">
                                {{ __('Second Driver') }}
                            </span>
                        </div>
                        @if (!$data->SClient)
                            <img src="{{ asset('img/mark.png') }}?v={{ env('APP_VERSION') }}"
                                class="w-full h-full absolute inset-0 z-10 object-center" />
                        @endif
                        <table class="w-full mt-2">
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('First Name') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? ucfirst($data->SClient->first_name) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Last Name') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? strtoupper($data->SClient->last_name) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Brith Date') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->birth_date)->format($format_middle) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('License number') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->license_number : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Delivered On') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->license_issued_at)->format($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-xs text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->SClient ? ucfirst(__(strtolower($data->SClient->license_issued_in))) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ $data->SClient ? ucfirst(__($data->SClient->identity_type)) : 'N/A' }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->identity_number : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Delivered On') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? \Carbon\Carbon::parse($data->SClient->identity_issued_at)->format($format_middle) : 'N/A' }}
                                    <span class="inline-block w-max px-1 text-xs text-x-black font-x-thin">
                                        {{ __('At') }}
                                    </span>
                                    {{ $data->SClient ? ucfirst(__(strtolower($data->SClient->identity_issued_in))) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Phone') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? $data->SClient->phone : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Address') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->SClient ? ucfirst($data->SClient->address) . ' ' . ucfirst(__($data->SClient->city)) . ', ' . $data->SClient->zipcode : 'N/A' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="w-full border border-x-x-black border-y-x-black relative">
                    <div class="w-max absolute left-1/2 -translate-x-1/2 -top-3">
                        <span
                            class="block w-max text-base font-x-thin bg-x-white border border-x-x-black border-y-x-black px-2">
                            {{ __('Vehicle Condition') }}
                        </span>
                    </div>
                    <div class="w-full flex items-end p-2 border-b border-b-black">
                        <table class="w-full mt-2">
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Fuel Level') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->fuel_level }} %
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Starting Mileage') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->mileage }} {{ __('Km') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Advance') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Payment ? Core::formatNumber($data->Payment->paid) : '?' }}
                                    {{ Core::setting() ? Core::setting('currency') : '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="w-full mt-2 ms-4">
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Return Mileage') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Recovery ? $data->Recovery->mileage : '?' }}
                                    {{ __('Km') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[130px] pe-1 text-xs text-x-black font-x-thin">
                                    {{ __('Creance') }}
                                </td>
                                <td class="w-4 text-xs text-x-black font-x-thin">:</td>
                                <td class="text-xs text-x-black text-opacity-70 font-x-thin">
                                    {{ $data->Payment ? Core::formatNumber($data->Payment->rest) : '?' }}
                                    {{ Core::setting() ? Core::setting('currency') : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="w-full flex justify-center p-2 gap-4">
                        <div class="w-1/2 relative">
                            <img id="img" src="{{ asset('img/state.png') }}" class="block w-full" />
                            <svg viewBox="0 0 819.000000 476.000000" class="block w-full h-full absolute inset-0">
                                <g transform="translate(0.000000,476.000000) scale(0.100000,-0.100000)" fill="transparent"
                                    stroke="none">
                                    @foreach (Core::pathList() as $key => $path)
                                        <path id="part-{{ $key + 1 * 100 }}" class="path cursor-pointer"
                                            d="{{ $path }}" />
                                    @endforeach
                                </g>
                            </svg>
                        </div>
                        <ul class="w-1/3 flex justify-center items-center flex-wrap gap-2 my-auto">
                            @foreach (collect(json_decode($data->condition)) as $i)
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span class="block w-3 h-3 rounded-full"
                                        style="background:{{ $i->color }}"></span>
                                    <span class="block text-sm">
                                        {{ ucfirst(__($i->name)) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="w-full p-2 flex flex-col gap-2 border border-x-x-black border-y-x-black -mt-3 flex-1">
                    <p class="text-x-black text-xs font-x-thin text-center">
                        {{ __('I, the undersigned, tenant of the vehicle whose information is cited above, acknowledge having read the general rental conditions on the reverse side and accept the rates mentioned above.') }}
                    </p>
                    <div class="w-full flex gap-4 px-10 flex-1">
                        <div class="flex w-full p-2 border border-x-x-black border-y-x-black me-8 h-full">
                            <span class="block mx-auto text-x-black font-x-thin text-xs text-center">
                                {{ Core::company() ? ucfirst(Core::company('name')) : '' }}
                            </span>
                        </div>
                        <div class="flex w-full p-2 border border-x-x-black border-y-x-black h-full">
                            <span class="block mx-auto text-x-black font-x-thin text-xs text-center">
                                {{ $data->Client ? strtoupper($data->Client->last_name) . ' ' . ucfirst($data->Client->first_name) : __('Renter') . ' 1' }}
                            </span>
                        </div>
                        <div class="flex w-full p-2 border border-x-x-black border-y-x-black h-full relative">
                            @if (!$data->SClient)
                                <img src="{{ asset('img/mark.png') }}?v={{ env('APP_VERSION') }}"
                                    class="w-full h-full absolute inset-0 z-10 object-center" />
                            @endif
                            <span class="block mx-auto text-x-black font-x-thin text-xs text-center">
                                {{ $data->SClient ? strtoupper($data->SClient->last_name) . ' ' . ucfirst($data->SClient->first_name) : __('Renter') . ' 2' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="w-1/2 ms-auto flex gap-2">
                            <span class="text-x-black text-xs font-x-huge">
                                {{ __('Contract Valid Until') }} <span class="text-x-black text-opacity-70">
                                    {{ \Carbon\Carbon::parse($data->dropoff_date)->format($format_middle) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-4">
                <neo-foot
                    class="w-full flex flex-wrap items-center text-sm justify-center gap-2 p-2 border border-x-x-black border-y-x-black">
                    @if (Core::company())
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('ICE number') }}:</span>
                            <span>{{ Core::company('ice_number') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Decision number') }}:</span>
                            <span>{{ Core::company('license_number') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Phone') }}:</span>
                            <span>{{ Core::company('phone') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Email') }}:</span>
                            <span>{{ Core::company('email') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Address') }}:</span>
                            <span>
                                {{ ucfirst(Core::company('address')) . ' ' . ucfirst(__(Core::company('city'))) . ' ' . Core::company('zipcode') }}
                            </span>
                        </div>
                    @endif
                </neo-foot>
            </div>
        </neo-paper>
        <neo-paper class="flex flex-col h-[295.5mm] relative">
            <div class="px-4 pt-4">
                <neo-head
                    class="w-full flex flex-wrap items-center justify-between gap-4 p-2 border border-x-x-black border-y-x-black">
                    @if (Core::company())
                        <h1 class="text-2xl text-x-black font-x-huge">
                            {{ strtoupper(Core::company('name')) }}
                        </h1>
                    @endif
                    <img id="logo" class="block h-[58px]"
                        src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}" />
                </neo-head>
            </div>
            <div class="w-full grid grid-rows-1 grid-cols-1 gap-6 mt-10 mb-auto px-4">
                <div class="w-full flex flex-col gap-1 rtl:mt-3">
                    <h1 class="text-2xl text-center text-x-black font-x-huge">
                        {{ __('COMMITMENT AGREEMENT') }}</h1>
                    <h2 class="text-xl text-center text-x-black font-x-thin px-6">
                        {{ __('Commitment to Adhere to the Rules of No Smoking and No Alcohol Consumption in the Rented Vehicle') }}
                    </h2>
                </div>
                <ul class="flex flex-col">
                    <li class="w-full">
                        <span class="w-max pe-1 text-xs text-x-black font-x-thin">
                            {{ __('I, the undersigned') }}
                        </span>
                        <span class="w-4 text-xs text-x-black font-x-thin">:</span>
                        <span class="text-xs text-x-prime text-opacity-70 font-x-thin">
                            {{ $data->Client ? strtoupper($data->Client->last_name) . ' ' . ucfirst($data->Client->first_name) : 'N/A' }}
                        </span>
                    </li>
                    <li class="w-full">
                        <span class="w-max pe-1 text-xs text-x-black font-x-thin">
                            {{ __('Commit to') }}
                        </span>
                        <span class="w-4 text-xs text-x-black font-x-thin">:</span>
                        <span class="text-xs text-x-prime text-opacity-70 font-x-thin">
                            {{ Core::company() ? ucfirst(Core::company('name')) : '' }}
                        </span>
                    </li>
                    <li class="w-full">
                        <span class="w-max pe-1 text-xs text-x-black font-x-thin">
                            {{ __('To adhere to the following rules during the use of the vehicle') }}
                        </span>
                        <span class="w-4 text-xs text-x-black font-x-thin">:</span>
                    </li>
                    <li class="w-full">
                        <span class="w-max pe-1 text-xs text-x-black font-x-thin">
                            {{ __('Registration number') }}
                        </span>
                        <span class="w-4 text-xs text-x-black font-x-thin">:</span>
                        <span class="text-xs text-x-prime text-opacity-70 font-x-thin">
                            {{ $data->Vehicle ? strtoupper($data->Vehicle->registration_number) : 'N/A' }}
                        </span>
                        <span class="w-max px-1 text-xs text-x-black font-x-thin">
                            {{ __('rented on') }}
                        </span>
                        <span class="w-4 text-xs text-x-black font-x-thin">:</span>
                        <span class="text-xs text-x-prime text-opacity-70 font-x-thin">
                            {{ \Carbon\Carbon::parse($data->pickup_date)->format($format_middle) }}
                        </span>
                        <span class="w-max px-1 text-xs text-x-black font-x-thin">
                            {{ __('at') }}
                        </span>
                        <span class="text-xs text-x-prime text-opacity-70 font-x-thin">
                            {{ Core::company() ? ucfirst(Core::company('city')) : '' }}
                        </span>
                    </li>
                </ul>
                <ul class="flex flex-col gap-6">
                    <li class="w-full flex flex-col gap-2">
                        <h3 class="text-base text-start text-x-black font-x-huge">
                            1. {{ __('No Smoking') }}
                        </h3>
                        <div class="flex flex-col">
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ __('I hereby formally commit to not smoking in the vehicle, whether it be cigarettes, cigars, pipes, or vaping devices. This prohibition applies to myself as well as to all passengers in the vehicle.') }}
                            </p>
                        </div>
                    </li>
                    <li class="w-full flex flex-col gap-2">
                        <h3 class="text-base text-start text-x-black font-x-huge">
                            2. {{ __('Prohibition of Alcohol Consumption') }}
                        </h3>
                        <div class="flex flex-col">
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ __('I also commit to not consuming alcoholic beverages inside the vehicle and to ensuring that all passengers adhere to this rule.') }}
                            </p>
                        </div>
                    </li>
                    <li class="w-full flex flex-col gap-2">
                        <h3 class="text-base text-start text-x-black font-x-huge">
                            3. {{ __('Penalties for Non-Compliance') }}
                        </h3>
                        <div class="flex flex-col">
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {!! __(
                                    'In the event of a violation of the no-smoking policy, I understand and accept that I will be required to pay a fixed fine of <span class="text-x-prime">:price</span> to cover the costs of deep cleaning and deodorizing the vehicle.',
                                    ['price' => '20,000 MAD'],
                                ) !!}
                            </p>
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {!! __(
                                    'In the event of consuming alcoholic beverages in the vehicle, I also understand and accept that I will be required to pay a fixed fine of <span class="text-x-prime">:price</span> to cover the necessary cleaning and deodorizing costs.',
                                    ['price' => '30,000 MAD'],
                                ) !!}
                            </p>
                        </div>
                    </li>
                    <li class="w-full flex flex-col gap-2">
                        <h3 class="text-base text-start text-x-black font-x-huge">
                            4. {{ __('Inspection and Additional Fees') }}
                        </h3>
                        <div class="flex flex-col">
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ __('Upon return of the vehicle, an inspection will be conducted by a company representative. If traces of smoke or alcohol are detected, the applicable fine will be immediately deducted from my deposit or billed to me.') }}
                            </p>
                            <p class="text-xs text-x-black text-opacity-70 font-x-thin">
                                {{ __('In the event of additional damage or cleaning costs exceeding the fixed fine amount, I agree to pay the difference. By signing this document, I confirm that I have read, understood, and accepted these terms. I commit to adhering strictly to them and acknowledge that any violation will result in the financial penalties described above.') }}
                            </p>
                        </div>
                    </li>
                </ul>
                <div class="w-full flex gap-4 px-10">
                    <div class="flex w-full p-2 border-y-x-black me-8 min-h-[3.5rem]">
                        <span class="block mx-auto text-x-black font-x-huge text-sm text-center">
                            {{ __('Signature of the Agency Representative') }}
                        </span>
                    </div>
                    <div class="flex w-full p-2 border-y-x-black min-h-[3.5rem]">
                        <span class="block mx-auto text-x-black font-x-huge text-sm text-center">
                            {{ __('Signature of Client') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-4">
                <neo-foot
                    class="w-full flex flex-wrap items-center text-sm justify-center gap-2 p-2 border border-x-x-black border-y-x-black">
                    @if (Core::company())
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('ICE number') }}:</span>
                            <span>{{ Core::company('ice_number') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Decision number') }}:</span>
                            <span>{{ Core::company('license_number') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Phone') }}:</span>
                            <span>{{ Core::company('phone') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Email') }}:</span>
                            <span>{{ Core::company('email') }}</span>
                        </div>
                        <div class="flex w-max gap-1">
                            <span class="font-x-thin">{{ __('Address') }}:</span>
                            <span>
                                {{ ucfirst(Core::company('address')) . ' ' . ucfirst(__(Core::company('city'))) . ' ' . Core::company('zipcode') }}
                            </span>
                        </div>
                    @endif
                </neo-foot>
            </div>
        </neo-paper>
        <neo-paper dir="ltr" class="flex flex-col h-[295.5mm] relative">
            <div class="px-4 pt-4">
                <neo-head class="w-full bg-x-light p-4 gap-6 flex flex-wrap items-center">
                    <div class="flex-1 flex flex-col">
                        <h1 class="text-lg text-center text-x-black font-x-huge">
                            {{ __('Royaume du Maroc') }}</h1>
                        <h2 class="text-base text-center text-x-black">
                            {{ __('Ministère de l’Équipement, du Transport et de la Logistique') }}
                        </h2>
                    </div>
                    <img id="logo" class="block w-24"
                        src="{{ asset('img/trans.png') }}?v={{ env('APP_VERSION') }}" />
                    <div class="flex-1 flex flex-col">
                        <h1 class="text-lg text-center text-x-black font-x-huge">
                            {{ __('المملكة المغربية') }}</h1>
                        <h2 class="text-base text-center text-x-black">
                            {{ __('وزارة التجهيز والنقل واللوجستيك') }}
                        </h2>
                    </div>
                </neo-head>
            </div>
            <div class="w-full grid grid-rows-1 grid-cols-1 gap-6 mt-10 mb-auto px-4">
                <div class="w-full flex flex-col gap-1">
                    <h1 class="text-2xl text-center text-x-black font-x-huge">
                        {{ __('التصريح المسبق لاستئجار سيارة بدون سائق') }}</h1>
                    <h2 class="text-xl text-center text-x-black">
                        {{ __('(يجب تعبئته من قبل المستأجر المقيم في المغرب)') }}
                    </h2>
                    <h1 class="text-2xl text-center text-x-black font-x-huge">
                        {{ __('Déclaration préalable de location de voiture sans chauffeur') }}
                    </h1>
                    <h2 class="text-xl text-center text-x-black">
                        {{ __('(à renseigner par le locataire résidant au Maroc)') }}
                    </h2>
                </div>
                <div class="w-full border border-x-black">
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('Je soussigné(e)') }}:
                        </div>
                        <div class="w-px bg-x-black"></div>
                        <div dir="rtl" class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('أنا الموقع أدناه') }}:
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Nom') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? strtoupper($data->Client->last_name) : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('الاسم العائلي') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Prénom') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? ucfirst($data->Client->first_name) : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('لاسم الشخصي') }}
                        </div>
                    </div>
                    <div class="w-full flex items-end flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin border-e border-e-x-black">
                            {{ __('N° de la C.N.I.E') }}</br>
                            {{ __('Ou carte de séjour') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? $data->Client->identity_number : 'N/A' }}
                        </div>
                        <div dir="rtl"
                            class="p-1 w-[200px] text-xs text-x-black font-x-thin border-e border-e-x-black">
                            {{ __('رقم البطاقة الوطنية') }}</br>
                            {{ __('أو بطاقة الإقامة') }}
                        </div>
                    </div>
                    <div class="w-full flex items-end flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('N° du permis de conduire') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin border-x border-x-x-black">
                            {{ $data->Client ? $data->Client->license_number : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('رقم رخصة القيادة') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Adresse') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? ucfirst($data->Client->address) : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('العنوان') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Ville') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? ucfirst(__($data->Client->city)) : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('المدينة') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Code postal') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? $data->Client->zipcode : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('الرمز البريدي') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('N° de GSM') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? $data->Client->phone : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('الهاتف المحمول') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Adresse mail') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Client ? $data->Client->email : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('البريد الإلكتروني') }}
                        </div>
                    </div>
                    <div class="w-full flex items-end flex-wrap">
                        <div class="p-1 w-[230px] text-xs text-x-black font-x-thin">
                            {{ __('Déclare avoir pris en location le véhicule') }}</br>
                            {{ __('Immatriculé sous le numéro') }}:
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ $data->Vehicle ? strtoupper($data->Vehicle->registration_number) : 'N/A' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[230px] text-xs text-x-black font-x-thin">
                            {{ __('أقر بأنني قد استأجرت السيارة') }}</br>
                            {{ __('المسجلة تحت الرقم') }}:
                        </div>
                    </div>
                    <div class="w-full flex items-end flex-wrap border-b border-x-black">
                        <div class="p-1 w-[230px] text-xs text-x-black font-x-thin">
                            {{ __('et appartenant à l\'agence de location') }}
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                        </div>
                        <div dir="rtl" class="p-1 w-[230px] text-xs text-x-black font-x-thin">
                            {{ __('والمملوكة لوكالة التأجير') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-max text-xs text-x-black font-x-thin">
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                        </div>
                        <div class="p-1 w-max text-xs text-x-black font-x-thin">
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-max text-xs text-x-black font-x-thin">
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                        </div>
                        <div class="p-1 w-max text-xs text-x-black font-x-thin">
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black pt-4">
                        <div class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('Pour la période allant du') }}:
                        </div>
                        <div dir="rtl" class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('لفترة تبدأ من') }}:
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Jour d\'emprunt') }}
                            ({{ Core::setting() ? Core::setting('date_format') : 'JJ/MM/AAAA' }})
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ \Carbon\Carbon::parse($data->pickup_date)->format($format_last) }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('يوم الاستعارة') }}
                            ({{ Core::setting() ? Core::setting('date_format') : 'JJ/MM/AAAA' }})
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Heure d\'emprunt') }} (HH:MM)
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ \Carbon\Carbon::parse($data->pickup_date)->format('H:i') }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('ساعة الاستعارة') }} (HH:MM)
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('Au') }}:
                        </div>
                        <div dir="rtl" class="p-1 flex-1 text-xs text-x-black font-x-thin">
                            {{ __('إلى') }}:
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Jour de restitution') }}
                            ({{ Core::setting() ? Core::setting('date_format') : 'JJ/MM/AAAA' }})
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ \Carbon\Carbon::parse($data->dropoff_date)->format($format_last) }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('يوم التسليم') }}
                            ({{ Core::setting() ? Core::setting('date_format') : 'JJ/MM/AAAA' }})
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Heure de restitution') }} (HH:MM)
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ \Carbon\Carbon::parse($data->dropoff_date)->format('H:i') }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('ساعة التسليم') }} (HH:MM)
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black p-2"> </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Fait à') }}:
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ Core::company() ? strtoupper(__(Core::company('city'))) : '' }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('تم في') }}:
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap border-b border-x-black">
                        <div class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('Le') }}:
                        </div>
                        <div class="text-center p-1 flex-1 text-xs text-x-prime font-x-thin">
                            {{ \Carbon\Carbon::parse($data->created_at)->format($format_last) }}
                        </div>
                        <div dir="rtl" class="p-1 w-[200px] text-xs text-x-black font-x-thin">
                            {{ __('في') }}:
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap">
                        <div class="p-4 pb-12 flex-1 text-xs text-x-black font-x-thin text-center">
                            {{ __('توقيع وختم وكالة التأجير') }}<br>
                            {{ __('Signature et cachet de l\'agence de location') }}
                        </div>
                        <div class="w-px bg-x-black"></div>
                        <div class="p-4 pb-12 flex-1 text-xs text-x-black font-x-thin text-center">
                            {{ __('توقيع المستأجر') }}<br>
                            {{ __('Signature du locataire') }}
                        </div>
                    </div>
                </div>
            </div>
        </neo-paper>
    </neo-printer>
@endsection

@section('scripts')
    <script src="{{ asset('js/reservation/print.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
