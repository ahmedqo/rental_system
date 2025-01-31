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
        <div class="py-3 px-6 border-b border-x-shade">
            <label class="text-x-black font-x-thin text-xl">
                #{{ $data->reference }}
            </label>
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
                    <div class="w-full flex items-end p-4 border-b border-b-shade flex-col lg:flex-row">
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
                                {{ $data->Owner ? ucfirst($data->Owner->name) : '' }}
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
@endsection

@section('scripts')
    <script src="{{ asset('js/reservation/print.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
