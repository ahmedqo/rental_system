@extends('shared.core.base')
@section('title', __('Edit payment') . ' #' . $data->id)

@section('meta')
    <meta name="total" content="{{ $data->total }}" />
@endsection

@section('content')
    <form validate action="{{ route('actions.payments.patch', $data->id) }}" method="POST" class="w-full">
        @csrf
        @method('patch')
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
                            {{ __('Reference') }}
                        </label>
                        <neo-textbox disable placeholder="{{ __('Reference') }}" name="reference"
                            value="{{ $data->Reservation ? $data->Reservation->reference : null }}">
                        </neo-textbox>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Daily rate') }}
                        </label>
                        <neo-textbox disable placeholder="{{ __('Daily rate') }}" name="daily_rate"
                            value="{{ Core::formatNumber($data->daily_rate, true) }} {{ Core::setting() ? Core::setting('currency') : '' }}">
                        </neo-textbox>
                    </div>
                    @if ($data->Reservation && $data->Reservation->client)
                        <div class="flex flex-col gap-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Client') }}
                            </label>
                            <neo-textbox disable placeholder="{{ __('Client') }}" name="client"
                                value="{{ $data->Reservation ? ($data->Reservation->client ? strtoupper($data->Reservation->Client->last_name) . ' ' . ucfirst($data->Reservation->Client->first_name) : null) : null }}">
                            </neo-textbox>
                        </div>
                    @endif
                    @if ($data->Reservation && $data->Reservation->secondary_client)
                        <div class="flex flex-col gap-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Secondary client') }}
                            </label>
                            <neo-textbox disable placeholder="{{ __('Secondary client') }}" name="secondary_client"
                                value="{{ $data->Reservation ? ($data->Reservation->secondary_client ? strtoupper($data->Reservation->SClient->last_name) . ' ' . ucfirst($data->Reservation->SClient->first_name) : null) : null }}">
                            </neo-textbox>
                        </div>
                    @endif
                    @if ($data->Reservation && $data->Reservation->agency)
                        <div class="flex flex-col gap-1">
                            <label class="text-x-black font-x-thin text-base">
                                {{ __('Agency') }}
                            </label>
                            <neo-textbox disable placeholder="{{ __('Agency') }}" name="agency"
                                value="{{ $data->Reservation ? ($data->Reservation->agency ? ucfirst($data->Reservation->Agency->name) : null) : null }}">
                            </neo-textbox>
                        </div>
                    @endif
                    <div class="flex flex-col gap-1">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Vehicle') }}
                        </label>
                        <neo-textbox disable placeholder="{{ __('Vehicle') }}" name="vehicle"
                            value="{{ $data->Reservation ? ($data->Reservation->vehicle ? ucfirst(__($data->Reservation->Vehicle->brand)) . ' ' . ucfirst(__($data->Reservation->Vehicle->model)) . ' ' . $data->Reservation->Vehicle->year . ' (' . $data->Reservation->Vehicle->registration_number . ')' : null) : null }}">
                        </neo-textbox>
                    </div>
                </neo-tab-outlet>
                <neo-tab-outlet name="outlet-2" class="grid grid-cols-1 grid-rows-1 gap-6">
                    <input type="hidden" name="payment" value='{{ old('payment', $data->logs) ?? '[]' }}'>
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
                            class="w-max ms-auto outline outline-1 -outline-offset-1 outline-x-prime px-6 text-base lg:text-lg font-x-huge text-x-prime hover:outline-x-acent hover:text-x-white hover:bg-x-acent focus:outline-x-acent focus:text-x-white focus:bg-x-acent focus-within:outline-x-acent focus-within:text-x-white focus-within:bg-x-acent">
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
    <script src="{{ asset('js/payment/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
