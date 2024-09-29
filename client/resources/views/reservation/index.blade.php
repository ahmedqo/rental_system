@extends('shared.core.base')
@section('title', __('Reservations list'))

@section('meta')
    <meta name="routes" content='{!! json_encode([
        'filter' => route('actions.reservations.search'),
        'entire' => route('actions.reservations.filter'),
        'patch' => route('views.reservations.patch', 'XXX'),
        'print' => route('views.reservations.print', 'XXX'),
    ]) !!}' />
@endsection

@section('content')
    <div class="p-6 bg-x-white rounded-x-thin shadow-x-core">
        <neo-datavisualizer print search filter download title="{{ __('Reservations list') }}">
            <neo-switch slot="start" id="filter" active></neo-switch>
            <a slot="end" title="{{ __('Create') }}" href="{{ route('views.reservations.store') }}"
                aria-label="create_page_link"
                class="flex w-8 h-8 items-center justify-center text-x-white outline-none rounded-x-thin bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M479.825-185q-18.45 0-31.637-12.625Q435-210.25 435-231v-203H230q-18.375 0-31.688-13.56Q185-461.119 185-479.86q0-20.14 13.312-32.64Q211.625-525 230-525h205v-205q0-19.775 13.358-32.388Q461.716-775 480.158-775t32.142 12.612Q526-749.775 526-730v205h204q18.8 0 32.4 12.675 13.6 12.676 13.6 32.316 0 19.641-13.6 32.825Q748.8-434 730-434H526v203q0 20.75-13.65 33.375Q498.699-185 479.825-185Z" />
                </svg>
            </a>
            @include('shared.page.print')
        </neo-datavisualizer>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/reservation/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
