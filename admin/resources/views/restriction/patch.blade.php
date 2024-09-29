@extends('shared.core.base')
@section('title', __('Edit restriction') . ' #' . $data->id)

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'search' => route('actions.clients.search.all'),
    ]) !!}' />
@endsection

@section('content')
    <form validate action="{{ route('actions.restrictions.patch', $data->id) }}" method="POST"
        class="w-full p-6 bg-x-white rounded-x-thin shadow-x-core">
        @csrf
        @method('patch')
        <div class="w-full flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Client') }} (*)
                </label>
                <neo-autocomplete rules="required" errors='{"required": "{{ __('The client field is required') }}"}'
                    placeholder="{{ __('Client') }} (*)" set-value="id" set-query="name" name="client"
                    value="{{ old('client', $data->client) }}"
                    query="{{ old('client_name', $data->client ? strtoupper($data->Client->last_name) . ' ' . ucfirst($data->Client->first_name) : null) }}">
                    <input type="hidden" name="client_name"
                        value="{{ old('client_name', $data->client ? strtoupper($data->Client->last_name) . ' ' . ucfirst($data->Client->first_name) : null) }}">
                </neo-autocomplete>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Reasons') }}
                </label>
                <neo-textarea placeholder="{{ __('Reasons') }}" name="reasons" value="{{ old('reasons', $data->reasons) }}"
                    rows="6">
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
    <script src="{{ asset('js/restriction/share.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
