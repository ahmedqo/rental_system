<div slot="header" id="header-content">
    @if (Core::company())
        <h1 class="text-2xl text-x-black font-x-huge">
            {{ strtoupper(Core::company('name')) }}
        </h1>
    @endif
    <img id="logo"
        src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}" />
</div>
