@extends('shared.core.base')
@section('title', __('Payments list'))


@section('meta')
    <meta name="routes" content='{!! json_encode([
        'filter' => route('actions.payments.search'),
        'entire' => route('actions.payments.filter'),
        'patch' => route('views.payments.patch', 'XXX'),
    ]) !!}' />
@endsection

@section('content')
    <div class="bg-x-white rounded-x-thin shadow-x-core">
        <neo-datavisualizer print search filter download title="{{ __('Payments list') }}">
            <neo-switch slot="start" id="filter" active></neo-switch>
            @include('shared.page.print')
        </neo-datavisualizer>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/payment/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
