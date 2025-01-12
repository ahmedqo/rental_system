@extends('shared.core.base')
@section('title', __('New vehicle'))

@section('content')
    <form validate action="{{ route('actions.vehicles.store') }}" method="POST" class="w-full">
        @csrf
        <neo-tab-wrapper outlet="outlet-1" class="w-full flex flex-col gap-6">
            <div class="flex flex-wrap items-center justify-between gap-2 lg:gap-6 relative isolate">
                <div class="absolute h-1 w-full bg-x-white left-0 right-0 top-1/2 -translate-y-1/2 z-[-1]">
                    <div id="track" class="absolute h-full top-0 bottom-0 w-0 bg-x-prime"></div>
                </div>
                @for ($i = 1; $i <= 7; $i++)
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
                            {{ __('Registration type') }} (*)
                        </label>
                        <neo-select rules="required"
                            errors='{"required": "{{ __('The registration type field is required') }}"}'
                            placeholder="{{ __('Registration type') }} (*)" name="registration_type">
                            @foreach (Core::registrationList() as $registration_type)
                                <neo-select-item value="{{ $registration_type }}"
                                    {{ $registration_type == old('registration_type', 'vehicle') ? 'active' : '' }}>
                                    {{ ucfirst(__($registration_type)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div show-if="registration_type,WW" class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Registration number') }} (*)
                        </label>
                        <div class="w-full flex gap-[2px]">
                            <neo-textbox disable class="flex-[1]" name="registration_ww_part_1"
                                value="WW"></neo-textbox>
                            <neo-textbox rules="required_if:registration_type,WW"
                                errors='{"required_if": "{{ __('The registration number part 2 field is required') }}"}'
                                class="flex-[2]" placeholder="XXXXX (*)" name="registration_ww_part_2"
                                value="{{ old('registration_ww_part_2') }}"></neo-textbox>
                        </div>
                    </div>
                    <div show-if="registration_type,vehicle" class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Registration number') }} (*)
                        </label>
                        <div class="w-full flex gap-[2px]">
                            <neo-textbox rules="required_if:registration_type,vehicle"
                                errors='{"required_if": "{{ __('The registration number part 1 field is required') }}"}'
                                class="flex-[1]" placeholder="XXXXX (*)" name="registration_vehicle_part_1"
                                value="{{ old('registration_vehicle_part_1') }}"></neo-textbox>
                            <neo-select rules="required_if:registration_type,vehicle"
                                errors='{"required_if": "{{ __('The registration number part 2 field is required') }}"}'
                                class="flex-[1]" placeholder="X (*)" name="registration_vehicle_part_2">
                                @foreach (Core::alphaList() as $registration_part)
                                    <neo-select-item value="{{ $registration_part }}"
                                        {{ $registration_part == old('registration_vehicle_part_2') ? 'active' : '' }}>
                                        {{ ucfirst(__($registration_part)) }}
                                    </neo-select-item>
                                @endforeach
                            </neo-select>
                            <neo-textbox rules="required_if:registration_type,vehicle"
                                errors='{"required_if": "{{ __('The registration number part 3 field is required') }}"}'
                                class="flex-[1]" placeholder="XX (*)" name="registration_vehicle_part_3"
                                value="{{ old('registration_vehicle_part_3') }}"></neo-textbox>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Registration date') }} (*)
                        </label>
                        <neo-datepicker rules="required"
                            errors='{"required": "{{ __('The registration date field is required') }}"}'
                            {{ !Core::lang('ar') ? 'full-day=3' : '' }} placeholder="{{ __('Registration date') }} (*)"
                            name="registration_date" format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('registration_date') }}"></neo-datepicker>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-2" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Brand') }} (*)
                        </label>
                        <neo-autocomplete rules="required" errors='{"required": "{{ __('The brand field is required') }}"}'
                            handfree placeholder="{{ __('Brand') }} (*)" name="brand" value="{{ old('brand') }}"
                            query="{{ old('brand') }}">
                        </neo-autocomplete>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Model') }} (*)
                        </label>
                        <neo-autocomplete rules="required" errors='{"required": "{{ __('The model field is required') }}"}'
                            handfree placeholder="{{ __('Model') }} (*)" name="model" value="{{ old('model') }}"
                            query="{{ old('model') }}">
                        </neo-autocomplete>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Year') }} (*)
                        </label>
                        <neo-select rules="required" errors='{"required": "{{ __('The year field is required') }}"}'
                            placeholder="{{ __('Year') }} (*)" name="year">
                            @for ($year = date('Y') - 4; $year <= date('Y'); $year++)
                                <neo-select-item value="{{ $year }}" {{ $year == old('year') ? 'active' : '' }}>
                                    {{ $year }}
                                </neo-select-item>
                            @endfor
                        </neo-select>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-3" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Passenger capacity') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The passenger capacity field is required') }}"}' type="number"
                            placeholder="{{ __('Passenger capacity') }} (*)" name="passenger_capacity"
                            value="{{ old('passenger_capacity') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Cargo capacity') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The cargo capacity field is required') }}"}' type="number"
                            placeholder="{{ __('Cargo capacity') }} (*)" name="cargo_capacity"
                            value="{{ old('cargo_capacity') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Number of doors') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The number of doors field is required') }}"}' type="number"
                            placeholder="{{ __('Number of doors') }} (*)" name="number_of_doors"
                            value="{{ old('number_of_doors') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-4" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Transmission type') }} (*)
                        </label>
                        <neo-select rules="required"
                            errors='{"required": "{{ __('The transmission type field is required') }}"}'
                            placeholder="{{ __('Transmission type') }} (*)" name="transmission_type">
                            @foreach (Core::transmissionsList() as $transmission_type)
                                <neo-select-item value="{{ $transmission_type }}"
                                    {{ $transmission_type == old('transmission_type') ? 'active' : '' }}>
                                    {{ ucfirst(__($transmission_type)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Mileage') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The mileage field is required') }}"}'
                            type="number" placeholder="{{ __('Mileage') }} (*)" name="mileage"
                            value="{{ old('mileage') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Daily rate') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The daily rate field is required') }}"}' type="number"
                            placeholder="{{ __('Daily rate') }} (*)" name="daily_rate"
                            value="{{ old('daily_rate') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-5" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Fuel type') }} (*)
                        </label>
                        <neo-select rules="required" errors='{"required": "{{ __('The fuel type field is required') }}"}'
                            placeholder="{{ __('Fuel type') }} (*)" name="fuel_type">
                            @foreach (Core::fuelsList() as $fuel_type)
                                <neo-select-item value="{{ $fuel_type }}"
                                    {{ $fuel_type == old('fuel_type') ? 'active' : '' }}>
                                    {{ ucfirst(__($fuel_type)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Horsepower') }} (*)
                        </label>
                        <neo-select rules="required"
                            errors='{"required": "{{ __('The horsepower field is required') }}"}'
                            placeholder="{{ __('Horsepower') }} (*)" name="horsepower">
                            @foreach (Core::horsepowersList() as $horsepower)
                                <neo-select-item value="{{ $horsepower }}"
                                    {{ $horsepower == old('horsepower') ? 'active' : '' }}>
                                    {{ ucfirst(__($horsepower)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Horsepower tax') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The horsepower tax field is required') }}"}' type="number"
                            placeholder="{{ __('Horsepower tax') }} (*)" name="horsepower_tax"
                            value="{{ old('horsepower_tax') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-6" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Loan amount') }}
                        </label>
                        <neo-textbox type="number" placeholder="{{ __('Loan amount') }}" name="loan_amount"
                            value="{{ old('loan_amount') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="required-label text-x-black font-x-thin text-base">
                            {{ __('Monthly installment') }} {{ old('loan_amount') ? '(*)' : '' }}
                        </label>
                        <neo-textbox rules="required_with:loan_amount"
                            errors='{"required_with": "{{ __('The monthly installment field is required') }}"}'
                            type="number"
                            placeholder="{{ __('Monthly installment') }} {{ old('loan_amount') ? '(*)' : '' }}"
                            name="monthly_installment" class="required-input"
                            value="{{ old('monthly_installment') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="required-label text-x-black font-x-thin text-base">
                            {{ __('Loan issued at') }} {{ old('loan_amount') ? '(*)' : '' }}
                        </label>
                        <neo-datepicker rules="required_with:loan_amount"
                            errors='{"required_with": "{{ __('The loan issued at field is required') }}"}'
                            {{ !Core::lang('ar') ? 'full-day=3' : '' }}
                            placeholder="{{ __('Loan issued at') }} {{ old('loan_amount') ? '(*)' : '' }}"
                            class="required-input" name="loan_issued_at"
                            format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('loan_issued_at') }}"></neo-datepicker>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-7" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Insurance company') }} (*)
                        </label>
                        <neo-autocomplete rules="required"
                            errors='{"required": "{{ __('The insurance company field is required') }}"}' handfree
                            placeholder="{{ __('Insurance company') }} (*)" name="insurance_company"
                            value="{{ old('insurance_company') }}" query="{{ old('insurance_company') }}">
                        </neo-autocomplete>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Insurance issued at') }} (*)
                        </label>
                        <neo-datepicker rules="required"
                            errors='{"required": "{{ __('The insurance issued at field is required') }}"}'
                            {{ !Core::lang('ar') ? 'full-day=3' : '' }}
                            placeholder="{{ __('Insurance issued at') }} (*)" name="insurance_issued_at"
                            format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('insurance_issued_at') }}"></neo-datepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Insurance cost') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The insurance cost field is required') }}"}' type="number"
                            placeholder="{{ __('Insurance cost') }} (*)" name="insurance_cost"
                            value="{{ old('insurance_cost') }}"></neo-textbox>
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
    <script src="{{ asset('js/vehicle/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
