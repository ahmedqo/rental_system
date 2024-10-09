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
                Neo.Toaster.toast("{{ $message }}", "{{ Session::get('type') }}");
            @endforeach
        });
    </script>
@endif
