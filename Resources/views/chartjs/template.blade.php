<canvas id="{!! $element !!}" width="{!! $size['width'] !!}" height="{!! $size['height'] !!}"> </canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let optionsRaw = {!! $optionsRaw !!}
    optionsRaw.animation = {onComplete: function() { chartJsStoreImgApi(document.getElementById('{!! $element !!}').toDataURL()) }}

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
                options: optionsRaw
            });
        })();
    });
</script>