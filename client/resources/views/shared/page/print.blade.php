<img slot="top" id="backgroun-image"
    src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}" />
@if (Core::preference())
    @php
        $colors = Core::themesList(Core::preference('theme_color'));
    @endphp
    <style slot="styles">
        *,
        :root,
        *::after,
        *::before {
            --p-prime: {{ $colors[0] }};
            --p-acent: {{ $colors[1] }};
        }
    </style>
@endif
@include('shared.page.head')
@include('shared.page.foot')
