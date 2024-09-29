<img slot="top" id="backgroun-image"
    src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}" />
@include('shared.page.head')
@include('shared.page.foot')
