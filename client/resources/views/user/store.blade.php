@extends('shared.core.base')
@section('title', __('New user'))

@section('content')
    <form validate action="{{ route('actions.users.store') }}" method="POST" class="w-full">
        @csrf
        <neo-tab-wrapper outlet="outlet-1" class="w-full flex flex-col gap-6">
            <div class="flex flex-wrap items-center justify-between gap-2 lg:gap-6 relative isolate">
                <div class="absolute h-1 w-full bg-x-white left-0 right-0 top-1/2 -translate-y-1/2 z-[-1]">
                    <div id="track" class="absolute h-full top-0 bottom-0 w-0 bg-x-prime"></div>
                </div>
                @for ($i = 1; $i <= 2; $i++)
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
            <div class="w-full flex flex-col gap-6 p-6 bg-x-white rounded-x-thin shadow-x-core">
                <neo-tab-outlet name="outlet-1" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('First name') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The first name field is required') }}"}'
                            placeholder="{{ __('First name') }} (*)" name="first_name"
                            value="{{ old('first_name') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Last name') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The last name field is required') }}"}'
                            placeholder="{{ __('Last name') }} (*)" name="last_name"
                            value="{{ old('last_name') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Email') }} (*)
                        </label>
                        <neo-textbox rules="required|email"
                            errors='{"required": "{{ __('The email field is required') }}", "email": "{{ __('The email field must be a valid email') }}"}'
                            type="email" placeholder="{{ __('Email') }} (*)" name="email"
                            value="{{ old('email') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Phone') }} (*)
                        </label>
                        <neo-textbox rules="required|phone"
                            errors='{"required": "{{ __('The phone field is required') }}", "phone": "{{ __('The phone field must be a valid phone number') }}"}'
                            type="tel" placeholder="{{ __('Phone') }} (*)" name="phone"
                            value="{{ old('phone') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-2" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Gender') }}
                        </label>
                        <neo-select placeholder="{{ __('Gender') }}" name="gender">
                            @foreach (Core::genderList() as $gender)
                                <neo-select-item value="{{ $gender }}"
                                    {{ $gender == old('gender') ? 'active' : '' }}>
                                    {{ ucfirst(__($gender)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Birth date') }}
                        </label>
                        <neo-datepicker {{ !Core::lang('ar') ? 'full-day=3' : '' }} placeholder="{{ __('Birth date') }}"
                            name="birth_date" format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('birth_date') }}"></neo-datepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Address') }}
                        </label>
                        <neo-textarea placeholder="{{ __('Address') }}" name="address" value="{{ old('address') }}"
                            rows="4"></neo-textarea>
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
