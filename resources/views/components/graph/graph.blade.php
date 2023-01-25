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

                    console.log(config);
                    // const labels = ['marzo', 'aprile', 'maggio'];
                    const data = {
                        labels: config[0].labels,
                        // datasets: [{
                        //     axis: 'y',
                        //     label: 'My First Dataset',
                        //     data: [65, 59, 80, 81, 56, 55, 40],
                        //     fill: false,
                        //     backgroundColor: [
                        //         'rgba(255, 99, 132, 0.2)',
                        //         'rgba(255, 159, 64, 0.2)',
                        //         'rgba(255, 205, 86, 0.2)',
                        //         'rgba(75, 192, 192, 0.2)',
                        //         'rgba(54, 162, 235, 0.2)',
                        //         'rgba(153, 102, 255, 0.2)',
                        //         'rgba(201, 203, 207, 0.2)'
                        //     ],
                        //     borderColor: [
                        //         'rgb(255, 99, 132)',
                        //         'rgb(255, 159, 64)',
                        //         'rgb(255, 205, 86)',
                        //         'rgb(75, 192, 192)',
                        //         'rgb(54, 162, 235)',
                        //         'rgb(153, 102, 255)',
                        //         'rgb(201, 203, 207)'
                        //     ],
                        //     borderWidth: 1
                        // }]
                        datasets: config[0].datasets


                    };
                    const myChart = new Chart(this.ctx, {
                        type: config.type,
                        data,
                        // options: {
                        //     indexAxis: 'y',
                        // }
                        options: config.options
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
