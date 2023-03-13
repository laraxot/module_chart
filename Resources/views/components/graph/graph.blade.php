<div>
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
            constructor(id) {

                this.ctx = document.getElementById(id).getContext('2d');
                this.url = document.getElementById(id).getAttribute('url');
                // this.type = document.getElementById(id).getAttribute('type');

                console.log(id, this);

                this.load();
            }

            fetchData = async function() {
                const response = await fetch(this.url);
                const data = await response.json();
                return data;
            }

            load = function() {
                this.fetchData().then(config => {

                    const myChart = new Chart(this.ctx, config);
                });
            }

        }
    </script>
@endpushonce

@push('scripts')
    <script>
        new Graph('{{ $graph_id }}');
    </script>
@endpush
