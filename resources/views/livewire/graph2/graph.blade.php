<div wire:init="loadGraph" >
    <canvas id="{{ $graph_id }}" width="400" height="400"
        type="{{ $type }}" ></canvas>
    @php
        //  $url = url_queries(['api_token' => \Auth::user()->api_token], $url);
    @endphp
</div>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endpushonce

@push('scripts')

    <script>
        var chart{{$graph_id}} = new Chart(
            document.getElementById({{ $graph_id }}), @json($config)
        );
        Livewire.on('updateChart{{ $graph_id }}', data => {
            // chart.data =data['data'];
            // chart.options =data['options'];
            // chart.config.type =data['type'];
            // chart.update();
            chart{{$graph_id}}.destroy()
            chart{{$graph_id}} = new Chart(document.getElementById({{ $graph_id }}), data)
        });
    </script>
@endpush


