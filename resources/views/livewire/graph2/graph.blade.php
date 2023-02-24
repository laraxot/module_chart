<div wire:init="loadGraph" >

    @if($readyToLoadGraph)
        @livewire('graphdetails', ['url' => $url, 'id'=>$graph_id])
    @endif
    @php
        //  $url = url_queries(['api_token' => \Auth::user()->api_token], $url);
    @endphp
</div>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script >
        Chart.register(ChartDataLabels);
    </script>
@endpushonce





