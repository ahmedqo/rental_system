@extends('shared.core.base')
@section('title', __('Edit reminder') . ' #' . $data->id)

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'search' => route('actions.vehicles.search'),
    ]) !!}' />
@endsection

@section('content')
    <form validate action="{{ route('actions.reminders.patch', $data->id) }}" method="POST"
        class="w-full p-6 bg-x-white rounded-x-thin shadow-x-core">
        @csrf
        @method('patch')
        <div class="w-full grid grid-rows-1 grid-cols-1 gap-6">
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Vehicle') }} (*)
                </label>
                <neo-autocomplete rules="required" errors='{"required": "{{ __('The vehicle field is required') }}"}'
                    placeholder="{{ __('Vehicle') }} (*)" set-value="id" set-query="name" name="vehicle"
                    value="{{ old('vehicle', $data->vehicle) }}"
                    query="{{ old('vehicle_name', $data->vehicle ? ucfirst(__($data->Vehicle->brand)) . ' ' . ucfirst(__($data->Vehicle->model)) . ' ' . $data->Vehicle->year . ' (' . $data->Vehicle->registration_number . ')' : null) }}">
                    <input type="hidden" name="vehicle_name"
                        value="{{ old('vehicle_name', $data->vehicle ? ucfirst(__($data->Vehicle->brand)) . ' ' . ucfirst(__($data->Vehicle->model)) . ' ' . $data->Vehicle->year . ' (' . $data->Vehicle->registration_number . ')' : null) }}">
                </neo-autocomplete>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Consumable name') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The consumable name field is required') }}"}'
                    search placeholder="{{ __('Consumable name') }} (*)" name="consumable_name">
                    @foreach (Core::consumablesList() as $group => $list)
                        <neo-select-group label="{{ ucfirst(__($group)) }}">
                            @foreach ($list as $consumable)
                                <neo-select-item value="{{ $consumable }}"
                                    {{ $consumable == old('consumable_name', $data->consumable_name) ? 'active' : '' }}>
                                    {{ ucfirst(__($consumable)) }}
                                </neo-select-item>
                            @endforeach
                        </neo-select-group>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Unit of measurement') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The unit of measurement field is required') }}"}'
                    placeholder="{{ __('Unit of measurement') }} (*)" name="unit_of_measurement">
                    @foreach (Core::unitsList() as $unit_of_measurement)
                        <neo-select-item value="{{ $unit_of_measurement }}"
                            {{ $unit_of_measurement == old('unit_of_measurement', $data->unit_of_measurement) ? 'active' : '' }}>
                            {{ ucfirst(__($unit_of_measurement)) }}
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Recurrence amount') }} (*)
                </label>
                <neo-textbox rules="required" errors='{"required": "{{ __('The recurrence amount is required') }}"}'
                    type="number" placeholder="{{ __('Recurrence amount') }} (*)" name="recurrence_amount"
                    value="{{ old('recurrence_amount', $data->recurrence_amount) }}"></neo-textbox>
            </div>
            <div show-unless="unit_of_measurement,mileage" class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Reminder date') }} (*)
                </label>
                <neo-datepicker rules="required_unless:unit_of_measurement,mileage"
                    errors='{"required_unless": "{{ __('The reminder date is required') }}"}'
                    {{ !Core::lang('ar') ? 'full-day=3' : '' }} placeholder="{{ __('Reminder date') }} (*)"
                    name="reminder_date" format="{{ Core::formatsList(Core::setting('date_format'), 0) }}"
                    value="{{ old('reminder_date', $data->reminder_date) }}"></neo-datepicker>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Threshold value') }} (*)
                </label>
                <neo-textbox rules="required" errors='{"required": "{{ __('The threshold value is required') }}"}'
                    type="number" placeholder="{{ __('Threshold value') }} (*)" name="threshold_value"
                    value="{{ old('threshold_value', $data->threshold_value) }}"></neo-textbox>
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

@section('scripts')
    <script src="{{ asset('js/reminder/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
