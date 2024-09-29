@extends('shared.core.base')
@section('title', __('Edit charge') . ' #' . $data->id)

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'search' => route('actions.vehicles.search'),
    ]) !!}' />
@endsection

@section('content')
    <form validate action="{{ route('actions.charges.patch', $data->id) }}" method="POST"
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
                    {{ __('Name') }} (*)
                </label>
                <neo-textbox rules="required" errors='{"required": "{{ __('The name field is required') }}"}'
                    placeholder="{{ __('Name') }} (*)" name="name"
                    value="{{ old('name', $data->name) }}"></neo-textbox>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Cost') }} (*)
                </label>
                <neo-textbox rules="required" errors='{"required": "{{ __('The cost field is required') }}"}'
                    placeholder="{{ __('Cost') }} (*)" name="cost"
                    value="{{ old('cost', Core::formatNumber((float) $data->cost)) }}"></neo-textbox>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Details') }}
                </label>
                <neo-textarea placeholder="{{ __('Details') }}" name="details"
                    value="{{ old('details', $data->details) }}" rows="4">
                </neo-textarea>
            </div>
            <div class="w-full flex flex-wrap gap-6">
                <neo-button id="save"
                    class="w-max px-10 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                    <span>{{ __('Save') }}</span>
                </neo-button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/charge/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
