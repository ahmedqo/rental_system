<script src="{{ asset('js/neo/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
<script src="{{ asset('js/trans.min.js') }}?v={{ env('APP_VERSION') }}"></script>

@if ($type == 'admin')
    <script src="{{ asset('js/neo/plugins/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/index.min.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script>
        Neo.load(function() {
            Neo.getComponent("neo-datavisualizer").globals = [
                "{{ asset('css/print.min.css') }}?v={{ env('APP_VERSION') }}"
            ];
        });

        Neo.load(function() {
            Neo.getComponent("neo-printer").globals = [
                "{{ asset('css/index.min.css') }}?v={{ env('APP_VERSION') }}",
                "{{ asset('css/app.min.css') }}?v={{ env('APP_VERSION') }}",
                // "{{ asset('css/print.min.css') }}?v={{ env('APP_VERSION') }}"
            ];
        });
    </script>
@endif

@if ($type == 'guest')
    <script src="{{ asset('js/neo/plugins/guest.min.js') }}?v={{ env('APP_VERSION') }}"></script>
@endif

<script>
    Neo.load(function() {
        document.body.removeAttribute("close");
        document.body.querySelector("#neo-page-cover").remove();
        Neo.Helper.Theme.assign(
            "colors",
            "PRIME",
            getComputedStyle(document.documentElement)
            .getPropertyValue("--prime")
        );
        Neo.upgrade();
    });
</script>
@if (Session::has('message'))
    @php
        $messages = is_array(Session::get('message')) ? Session::get('message') : [Session::get('message')];
    @endphp
    <script>
        Neo.load(function() {
            @foreach ($messages as $message)
                @php
                    $type = Session::get('type');
                @endphp
                Neo.Toaster.toast("{{ $message }}", "{{ $type }}", null,
                    `<svg slot="start" class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor"><path d="{{ $type === 'success' ? 'M261-167-5-433l95-95 172 171 95 95-96 95Zm240-32L232-467l97-95 172 171 369-369 96 96-465 465Zm-7-280-95-95 186-186 95 95-186 186Z' : 'M480-40q-26 0-50.94-10.74Q404.12-61.48 384-80L80-384q-18.52-20.12-29.26-45.06Q40-454 40-480q0-26 10.59-51.12Q61.17-556.24 80-576l304-304q20.12-20.48 45.06-30.24Q454-920 480-920q26 0 51.12 9.91Q556.24-900.17 576-880l304 304q20.17 19.76 30.09 44.88Q920-506 920-480q0 26-9.76 50.94Q900.48-404.12 880-384L576-80q-19.76 18.83-44.88 29.41Q506-40 480-40Zm-60-382h120v-250H420v250Zm60 160q25.38 0 42.69-17.81Q540-297.63 540-322q0-25.38-17.31-42.69T480-382q-25.37 0-42.69 17.31Q420-347.38 420-322q0 24.37 17.31 42.19Q454.63-262 480-262Z' }}" /></svg>`
                    );
            @endforeach
        });
    </script>
@endif
