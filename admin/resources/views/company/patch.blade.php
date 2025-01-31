@extends('shared.core.base')
@section('title', __('Edit company') . ' #' . $data->id)

@section('meta')
    <meta name="image" content="{{ Core::route() . $data->Image->storage }}">
@endsection

@section('content')
    <form validate action="{{ route('actions.companies.patch', $data->id) }}" method="POST" enctype="multipart/form-data"
        class="w-full">
        @csrf
        @method('patch')
        <neo-tab-wrapper outlet="outlet-1" class="w-full flex flex-col gap-6">
            <div class="flex flex-wrap items-center justify-between gap-2 lg:gap-6 relative isolate">
                <div class="absolute h-1 w-full bg-x-white left-0 right-0 top-1/2 -translate-y-1/2 z-[-1]">
                    <div id="track" class="absolute h-full top-0 bottom-0 w-0 bg-x-prime"></div>
                </div>
                @for ($i = 1; $i <= 3; $i++)
                    <neo-tab-trigger tabindex="0" slot="triggers" for="outlet-{{ $i }}"
                        class="flex w-8 h-8 aspect-square items-center justify-center text-lg font-x-thin text-x-black bg-x-white rounded-x-thin outline-none hover:bg-x-acent hover:text-x-white focus:bg-x-acent focus:text-x-white">
                        <span>{{ $i }}</span>
                        <svg class="hidden w-6 h-6 pointer-events-none text-x-prime" fill="currentcolor"
                            viewBox="0 -960 960 960">
                            <path
                                d="M261-167-5-433l95-95 172 171 95 95-96 95Zm240-32L232-467l97-95 172 171 369-369 96 96-465 465Zm-7-280-95-95 186-186 95 95-186 186Z" />
                        </svg>
                    </neo-tab-trigger>
                @endfor
            </div>
            <div class="p-6 bg-x-white rounded-x-thin shadow-x-core w-full flex flex-col gap-6">
                <neo-tab-outlet name="outlet-1" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Logo') }} (*)
                        </label>
                        <neo-imagetransfer class="aspect-square lg:aspect-[16/5] p-2" placeholder="{{ __('Logo') }} (*)"
                            name="company_logo" value="{{ old('company_logo') }}"></neo-imagetransfer>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Name') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The name field is required') }}"}'
                            placeholder="{{ __('Name') }} (*)" name="name"
                            value="{{ old('name', $data->name) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('ICE number') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The ice number field is required') }}"}'
                            placeholder="{{ __('ICE number') }} (*)" name="ice_number"
                            value="{{ old('ice_number', $data->ice_number) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Decision number') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The decision number is required') }}"}'
                            placeholder="{{ __('Decision number') }} (*)" name="license_number"
                            value="{{ old('license_number', $data->license_number) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Mileage per day') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The mileage per day field is required') }}"}' type="number"
                            placeholder="{{ __('Mileage per day') }} (*)" name="mileage_per_day"
                            value="{{ old('mileage_per_day', $data->mileage_per_day) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Status') }} (*)
                        </label>
                        <neo-select rules="required" errors='{"required": "{{ __('The status field is required') }}"}'
                            search placeholder="{{ __('Status') }} (*)" name="status">
                            @foreach (Core::statsList() as $status)
                                <neo-select-item value="{{ $status }}"
                                    {{ $status == old('status', $data->status) ? 'active' : '' }}>
                                    {{ ucfirst(__($status)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-2" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Email') }} (*)
                        </label>
                        <neo-textbox rules="required|email"
                            errors='{"required": "{{ __('The email field is required') }}", "email": "{{ __('The email field must be a valid email') }}"}'
                            type="email" placeholder="{{ __('Email') }} (*)" name="email"
                            value="{{ old('email', $data->email) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Phone') }} (*)
                        </label>
                        <neo-textbox rules="required|phone"
                            errors='{"required": "{{ __('The phone field is required') }}", "phone": "{{ __('The phone field must be a valid phone number') }}"}'
                            type="tel" placeholder="{{ __('Phone') }} (*)" name="phone"
                            value="{{ old('phone', $data->phone) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('City') }} (*)
                        </label>
                        <neo-select rules="required" errors='{"required": "{{ __('The city field is required') }}"}' search
                            placeholder="{{ __('City') }} (*)" name="city">
                            @foreach (Core::citiesList() as $city)
                                <neo-select-item value="{{ $city }}"
                                    {{ $city == old('city', $data->city) ? 'active' : '' }}>
                                    {{ ucfirst(__($city)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Zopcode') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The zipcode field is required') }}"}'
                            type="number" placeholder="{{ __('Zopcode') }} (*)" name="zipcode"
                            value="{{ old('zipcode', $data->zipcode) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Address') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The address field is required') }}"}'
                            placeholder="{{ __('Address') }} (*)" name="address"
                            value="{{ old('address', $data->address) }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-3" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Representative first name') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The representative first name field is required') }}"}'
                            placeholder="{{ __('Representative first name') }} (*)" name="representative_first_name"
                            value="{{ old('representative_first_name', $data->Representative ? $data->Representative->first_name : null) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Representative last name') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The representative last name field is required') }}"}'
                            placeholder="{{ __('Representative last name') }} (*)" name="representative_last_name"
                            value="{{ old('representative_last_name', $data->Representative ? $data->Representative->last_name : null) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Representative email') }} (*)
                        </label>
                        <neo-textbox rules="required|email"
                            errors='{"required": "{{ __('The representative email field is required') }}", "email": "{{ __('The representative email field must be a valid email') }}"}'
                            type="email" placeholder="{{ __('Representative email') }} (*)"
                            name="representative_email"
                            value="{{ old('representative_email', $data->Representative ? $data->Representative->email : null) }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Representative phone') }} (*)
                        </label>
                        <neo-textbox rules="required|phone"
                            errors='{"required": "{{ __('The representative phone field is required') }}", "phone": "{{ __('The representative phone field must be a valid phone number') }}"}'
                            type="tel" placeholder="{{ __('Representative phone') }} (*)"
                            name="representative_phone"
                            value="{{ old('representative_phone', $data->Representative ? $data->Representative->phone : null) }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <div class="w-full flex flex-wrap gap-6">
                    <neo-button outline type="button" id="prev" style="display: none"
                        class="w-max me-auto outline outline-1 -outline-offset-1 outline-x-prime px-6 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                        <span>{{ __('Prev') }}</span>
                    </neo-button>
                    <neo-button id="save" style="display: none"
                        class="w-max px-6 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                        <span>{{ __('Save') }}</span>
                    </neo-button>
                    <neo-button outline type="button" id="next"
                        class="w-max ms-auto outline outline-1 -outline-offset-1 outline-x-prime px-6 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                        <span>{{ __('Next') }}</span>
                    </neo-button>
                </div>
            </div>
        </neo-tab-wrapper>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/company/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
