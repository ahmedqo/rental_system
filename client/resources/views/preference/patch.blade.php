@extends('shared.core.base')
@section('title', __('Edit preferences'))

@section('content')
    <form validate action="{{ route('actions.preferences.patch') }}" method="POST"
        class="w-full p-6 bg-x-white rounded-x-thin shadow-x-core">
        @csrf
        @method('patch')
        <div class="w-full grid grid-rows-1 grid-cols-1 gap-6">
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Report frequency') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The report frequency field is required') }}"}'
                    placeholder="{{ __('Report frequency') }} (*)" name="report_frequency">
                    @foreach (Core::periodsList() as $report_frequency)
                        <neo-select-item value="{{ $report_frequency }}"
                            {{ $report_frequency == old('report_frequency', $data->report_frequency) ? 'active' : '' }}>
                            {{ ucfirst(__($report_frequency)) }}
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Currency') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The currency field is required') }}"}'
                    placeholder="{{ __('Currency') }} (*)" name="currency" disable class="hide-icon">
                    @foreach (Core::currenciesList() as $cur => $currency)
                        <neo-select-item value="{{ $cur }}"
                            text="{{ strtoupper($cur) }} - {{ ucfirst(__($currency)) }}"
                            {{ $cur == old('currency', $data->currency) ? 'active' : '' }} class="flex items-center gap-1">
                            <span class="font-x-thin">{{ strtoupper($cur) }}</span>
                            <span>-</span>
                            <span>{{ ucfirst(__($currency)) }}</span>
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Language') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The language field is required') }}"}'
                    placeholder="{{ __('Language') }} (*)" name="language">
                    @foreach (Core::languagesList() as $lang => $language)
                        <neo-select-item value="{{ $lang }}"
                            {{ $lang == old('language', $data->language) ? 'active' : '' }}
                            class="flex flex-wrap gap-2 items-center">
                            <img src="{{ asset('lang/' . $lang . '.png') }}?v={{ env('APP_VERSION') }}" alt="english flag"
                                class="block w-10 h-6 object-contain" />
                            {{ ucfirst(__($language)) }}
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Date format') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The date format field is required') }}"}'
                    placeholder="{{ __('Date format') }} (*)" name="date_format">
                    @foreach (Core::formatsList() as $date_format => $formats)
                        <neo-select-item value="{{ $date_format }}" text="{{ ucfirst(__($date_format)) }}"
                            {{ $date_format == old('date_format', $data->date_format) ? 'active' : '' }}>
                            <span>{{ ucfirst(__($date_format)) }}</span><span class="mx-1"></span><span
                                class="text-x-shade">({{ \Carbon\Carbon::now()->translatedFormat($formats[1]) }})</span>
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Theme color') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The theme color field is required') }}"}'
                    placeholder="{{ __('Theme color') }} (*)" name="theme_color">
                    @foreach (Core::themesList() as $theme_color => $colors)
                        <neo-select-item value="{{ $theme_color }}"
                            {{ $theme_color == old('theme_color', $data->theme_color) ? 'active' : '' }}
                            class="flex flex-wrap gap-2 items-center">
                            <div class="w-max flex items-center">
                                <span
                                    class="block w-8 rounded-full border-2 border-x-x-white border-y-x-white aspect-square relative z-[1]"
                                    style="background-color: rgb({{ $colors[0] }})"></span>
                                <span
                                    class="-ms-4 block w-7 rounded-full border-2 border-x-x-white border-y-x-white aspect-square"
                                    style="background-color: rgb({{ $colors[1] }})"></span>
                            </div>
                            {{ ucfirst(__($theme_color)) }}
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="w-full flex flex-wrap gap-6">
                <neo-button id="save"
                    class="w-max px-6 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                    <span>{{ __('Save') }}</span>
                </neo-button>
            </div>
        </div>
    </form>
@endsection
