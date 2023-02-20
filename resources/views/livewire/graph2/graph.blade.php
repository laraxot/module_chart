<div wire:init="loadGraph">
    <canvas id="{{ $graph_id }}" width="400" height="400" url="{{ $url }}"
        type="{{ $type }}"></canvas>
    @php
        //  $url = url_queries(['api_token' => \Auth::user()->api_token], $url);
    @endphp
</div>


@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        class Graph {
            constructor(id, config) {

                this.ctx = document.getElementById(id).getContext('2d');
                this.url = document.getElementById(id).getAttribute('url');
                this.config = config;
                // this.type = document.getElementById(id).getAttribute('type');

                console.log(id, this);

                this.load();
            }


            load = function() {
                    // TODO: se il config è un array con più config vanno messi uno affianco all'altro
                    const myChart = new Chart(this.ctx,  this.config
                    );
            }

        }
    </script>
@endpushonce


@push('scripts')
    @if($load)
    <script>
        new Graph('{{ $graph_id }}', '{!! html_entity_decode($config) !!}');
    </script>
    @endif
@endpush


