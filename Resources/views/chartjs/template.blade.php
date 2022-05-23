<canvas id="{!! $element !!}" width="{!! $size['width'] !!}" height="{!! $size['height'] !!}"> </canvas>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            (function() {
                "use strict";
                var ctx = document.getElementById("{!! $element !!}");
                window.{!! $element !!} = new Chart(ctx, {
                    type: '{!! $type !!}',
                    data: {
                        labels: {!! json_encode($labels, JSON_INVALID_UTF8_IGNORE) !!},
                        datasets: {!! json_encode($datasets) !!}
                    },
                    options: {!! $optionsRaw !!}
                });
            })();
        });
    </script>
@endpush
