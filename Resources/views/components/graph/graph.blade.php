<div>
    <canvas id="{{ $graph_id }}" width="400" height="400" url="{{ $url }}"
        type="{{ $type }}"></canvas>
    @php
        //  $url = url_queries(['api_token' => \Auth::user()->api_token], $url);
    @endphp
</div>
@pushonce('scripts')
    <script>
        class Graph {
            constructor(id) {

                this.ctx = document.getElementById(id).getContext('2d');
                this.url = document.getElementById(id).getAttribute('url');
                this.type = document.getElementById(id).getAttribute('type');

                console.log(id, this);

                this.load();
            }

            fetchData = async function() {
                const response = await fetch(this.url);
                const data = await response.json();
                return data;
            }

            load = function() {
                this.fetchData().then(data => {
                    const myChart = new Chart(this.ctx, {
                        type: this.type,
                        data: data,
                        options: {
                            /*scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }*/
                        }
                    });
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
