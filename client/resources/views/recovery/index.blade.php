@extends('shared.core.base')
@section('title', __('Recoveries list'))


@section('meta')
    <meta name="routes" content='{!! json_encode([
        'filter' => route('actions.recoveries.search'),
        'entire' => route('actions.recoveries.filter'),
        'patch' => route('views.recoveries.patch', 'XXX'),
    ]) !!}' />
@endsection

@section('content')
    <div class="bg-x-white rounded-x-thin shadow-x-core">
        <neo-datavisualizer print search filter download title="{{ __('Recoveries list') }}">
            <neo-switch slot="start" id="filter" active></neo-switch>
            @include('shared.page.print')
        </neo-datavisualizer>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/recovery/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
