<div style="align-content: center;" >
    @php
    $i = 0;
    $padding = 0;
    @endphp
    @foreach($config as $c)
        @php
        if( $i> 0){
            $padding = "25%";
        }
        @endphp
        <div style="height: 100%; width: {{ (int)(100/ $num)-2}}%;   display: inline-block;">
    <canvas id="{{ $graph_id }}{{ $c['type'] }}{{ $i }}" width="100" height="100" style=" margin:2px; padding-top: {{ $padding }}"></canvas>

    <script>
        var conf{{ $graph_id }}{{ $c['type'] }}{{ $i }} = @json($c);
        var  chart{{ $graph_id }}{{ $c['type'] }}{{ $i }} = new Chart(document.getElementById("{{ $graph_id }}{{ $c['type'] }}{{ $i }}"), conf{{ $graph_id }}{{ $c['type'] }}{{ $i }} )


    </script>
        @php
        $i++
        @endphp
        </div>
    @endforeach
</div>





