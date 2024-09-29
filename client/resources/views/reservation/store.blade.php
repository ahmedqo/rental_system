@extends('shared.core.base')
@section('title', __('New reservation'))

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'client' => route('actions.clients.search.all'),
        'agency' => route('actions.agencies.search.all'),
        'vehicle' => route('actions.vehicles.search'),
        'info' => route('actions.vehicles.info', 'XXX'),
    ]) !!}' />
@endsection

@section('content')
    <form validate action="{{ route('actions.reservations.store') }}" method="POST" class="w-full">
        @csrf
        <neo-tab-wrapper outlet="outlet-1" class="w-full flex flex-col gap-6">
            <div class="flex flex-wrap items-center justify-between gap-2 lg:gap-6 relative isolate">
                <div class="absolute h-1 w-full bg-x-white left-0 right-0 top-1/2 -translate-y-1/2 z-[-1]">
                    <div id="track" class="absolute h-full top-0 bottom-0 w-0 bg-x-prime"></div>
                </div>
                @for ($i = 1; $i <= 6; $i++)
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
                            {{ __('Renter') }} (*)
                        </label>
                        <neo-select rules="required" errors='{"required": "{{ __('The renter field is required') }}"}'
                            placeholder="{{ __('Renter') }} (*)" name="renter">
                            @foreach (Core::reservationsList() as $renter)
                                <neo-select-item value="{{ $renter }}"
                                    {{ $renter == old('renter', 'individual') ? 'active' : '' }}>
                                    {{ ucfirst(__($renter)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select>
                    </div>
                    <div show-if="renter,individual" class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Client') }} (*)
                        </label>
                        <neo-autocomplete rules="required_if:renter,individual"
                            errors='{"required_if": "{{ __('The client field is required') }}"}'
                            placeholder="{{ __('Client') }} (*)" set-value="id" set-query="name" name="client"
                            value="{{ old('client') }}" query="{{ old('client_name') }}">
                            <input type="hidden" name="client_name" value="{{ old('client_name') }}">
                        </neo-autocomplete>
                    </div>
                    <div show-if="renter,individual" class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Secondary client') }}
                        </label>
                        <neo-autocomplete rules="custom_clash:client"
                            errors='{"custom_clash": "{{ __('The secondary client field must be different of client field') }}"}'
                            placeholder="{{ __('Secondary client') }}" set-value="id" set-query="name"
                            name="secondary_client" value="{{ old('secondary_client') }}"
                            query="{{ old('secondary_client_name') }}">
                            <input type="hidden" name="secondary_client_name" value="{{ old('secondary_client_name') }}">
                        </neo-autocomplete>
                    </div>
                    <div show-if="renter,agency" class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Agency') }} (*)
                        </label>
                        <neo-autocomplete rules="required_if:renter,agency"
                            errors='{"required_if": "{{ __('The agency field is required') }}"}'
                            placeholder="{{ __('Agency') }} (*)" set-value="id" set-query="name" name="agency"
                            value="{{ old('agency') }}" query="{{ old('agency_name') }}">
                            <input type="hidden" name="agency_name" value="{{ old('agency_name') }}">
                        </neo-autocomplete>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Vehicle') }} (*)
                        </label>
                        <neo-autocomplete rules="required"
                            errors='{"required": "{{ __('The vehicle field is required') }}"}'
                            placeholder="{{ __('Vehicle') }} (*)" set-value="id" set-query="name" name="vehicle"
                            value="{{ old('vehicle') }}" query="{{ old('vehicle_name') }}">
                            <input type="hidden" name="vehicle_name" value="{{ old('vehicle_name') }}">
                        </neo-autocomplete>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-2" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Pickup date') }} (*)
                        </label>
                        <neo-datepicker rules="required"
                            errors='{"required": "{{ __('The pickup date field is required') }}"}'
                            {{ !Core::lang('ar') ? 'full-day=3' : '' }} placeholder="{{ __('Pickup date') }} (*)"
                            name="pickup_date" format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('pickup_date', '#now') }}"></neo-datepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Pickup time') }} (*)
                        </label>
                        <neo-timepicker rules="required"
                            errors='{"required": "{{ __('The pickup time field is required') }}"}'
                            placeholder="{{ __('Pickup time') }} (*)" name="pickup_time" format="hh:MM  A"
                            value="{{ old('pickup_time', '#now') }}"></neo-timepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Pickup location') }}
                        </label>
                        <neo-textbox placeholder="{{ __('Pickup location') }}" name="pickup_location"
                            value="{{ old('pickup_location') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-3" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Dropoff date') }} (*)
                        </label>
                        <neo-datepicker rules="required"
                            errors='{"required": "{{ __('The dropoff date field is required') }}"}'
                            {{ !Core::lang('ar') ? 'full-day=3' : '' }} placeholder="{{ __('Dropoff date') }} (*)"
                            name="dropoff_date" format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                            value="{{ old('dropoff_date', '#now+1') }}"></neo-datepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Dropoff time') }} (*)
                        </label>
                        <neo-timepicker rules="required"
                            errors='{"required": "{{ __('The dropoff time field is required') }}"}'
                            placeholder="{{ __('Dropoff time') }} (*)" name="dropoff_time" format="hh:MM  A"
                            value="{{ old('dropoff_time', '#now') }}"></neo-timepicker>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Dropoff location') }}
                        </label>
                        <neo-textbox placeholder="{{ __('Dropoff location') }}" name="dropoff_location"
                            value="{{ old('dropoff_location') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-4" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Daily rate') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The daily rate field is required') }}"}' type="number"
                            placeholder="{{ __('Daily rate') }} (*)" name="daily_rate"
                            value="{{ old('daily_rate') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Fuel level') }} (*)
                        </label>
                        <neo-textbox rules="required"
                            errors='{"required": "{{ __('The fuel level field is required') }}"}' type="number"
                            placeholder="{{ __('Fuel level') }} (*)" name="fuel_level"
                            value="{{ old('fuel_level') }}"></neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Mileage') }} (*)
                        </label>
                        <neo-textbox rules="required" errors='{"required": "{{ __('The mileage field is required') }}"}'
                            type="number" placeholder="{{ __('Mileage') }} (*)" name="mileage"
                            value="{{ old('mileage') }}"></neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-5" class="grid grid-cols-1 grid-rows-1 lg:grid-cols-12 items-start gap-6">
                    <input type="hidden" name="condition"
                        value='{{ old('condition', '[{"name":"good","color":"#6eb9f7"}]') }}'>
                    <div class="flex flex-col flex-wrap gap-6 lg:flex-row lg:items-end lg:col-span-12">
                        <div class="flex flex-col gap-1 lg:flex-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Conditions') }}
                            </label>
                            <neo-select placeholder="{{ __('Conditions') }}" name="damage">
                                @foreach (Core::damagesList() as $damage)
                                    <neo-select-item value="{{ $damage }}">
                                        {{ ucfirst(__($damage)) }}
                                    </neo-select-item>
                                @endforeach
                            </neo-select>
                        </div>
                        <neo-button outline id="add-condition" type="button"
                            class="w-max ms-auto outline outline-1 -outline-offset-1 outline-x-prime px-10 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                            <span>{{ __('Add') }}</span>
                        </neo-button>
                    </div>
                    <div class="w-full rounded-x-thin p-4 bg-x-white border border-x-shade lg:col-span-7">
                        <div class="w-full relative">
                            <img src="{{ asset('img/state.png') }}" class="block w-full" />
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
                    </div>
                    <div
                        class="w-full rounded-x-thin overflow-x-auto overflow-y-hidden border border-x-shade lg:col-span-5">
                        <table class="w-max min-w-full">
                            <thead class="bg-x-light">
                                <tr>
                                    <td class="text-start px-4 py-2 text-x-black font-x-thin text-sm">
                                        {{ __('Conditions') }}
                                    </td>
                                    <td class="pe-6 text-center w-20 px-4 py-2 text-x-black font-x-thin text-sm"></td>
                                </tr>
                            </thead>
                            <tbody id="content-condition-table"></tbody>
                        </table>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-6" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <input type="hidden" name="payment" value='{{ old('payment', '[]') }}'>
                    <div class="flex flex-col flex-wrap gap-6 lg:flex-row lg:items-end">
                        <div class="flex flex-col gap-1 lg:flex-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Amount') }}
                            </label>
                            <neo-textbox type="number" placeholder="{{ __('Amount') }}"
                                name="payment_amount"></neo-textbox>
                        </div>
                        <div class="flex flex-col gap-1 lg:flex-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Method') }}
                            </label>
                            <neo-select placeholder="{{ __('Method') }}" name="payment_method">
                                @foreach (Core::methodsList() as $payment_method)
                                    <neo-select-item value="{{ $payment_method }}">
                                        {{ ucfirst(__($payment_method)) }}
                                    </neo-select-item>
                                @endforeach
                            </neo-select>
                        </div>
                        <neo-button outline id="add-payment" type="button"
                            class="w-max ms-auto outline outline-1 -outline-offset-1 outline-x-prime px-10 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                            <span>{{ __('Add') }}</span>
                        </neo-button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Payments') }}
                        </label>
                        <div class="w-full rounded-x-thin overflow-x-auto overflow-y-hidden border border-x-shade">
                            <table class="w-max min-w-full">
                                <thead class="bg-x-light">
                                    <tr>
                                        <td></td>
                                        <td class="text-start px-4 py-2 text-x-black font-x-thin text-sm">
                                            {{ __('Date') }}
                                        </td>
                                        <td class="text-center px-4 py-2 text-x-black font-x-thin text-sm">
                                            {{ __('Method') }}
                                        </td>
                                        <td class="min-w-[200px] text-center px-4 py-2 text-x-black font-x-thin text-sm">
                                            {{ __('Amount') }}
                                        </td>
                                        <td class="pe-6 text-center w-20 px-4 py-2 text-x-black font-x-thin text-sm"></td>
                                    </tr>
                                </thead>
                                <tbody id="content-payment-table"></tbody>
                            </table>
                        </div>
                    </div>
                </neo-tab-outlet>
                <div class="w-full flex flex-wrap gap-6">
                    <neo-button outline type="button" id="prev" style="display: none"
                        class="w-max me-auto outline outline-1 -outline-offset-1 outline-x-prime px-10 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                        <span>{{ __('Prev') }}</span>
                    </neo-button>
                    <neo-button id="save" style="display: none"
                        class="w-max px-10 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                        <span>{{ __('Save') }}</span>
                    </neo-button>
                    <neo-button outline type="button" id="next"
                        class="w-max ms-auto outline outline-1 -outline-offset-1 outline-x-prime px-10 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                        <span>{{ __('Next') }}</span>
                    </neo-button>
                </div>
            </div>
        </neo-tab-wrapper>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/reservation/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
