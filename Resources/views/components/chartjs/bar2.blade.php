<div class="chart-container" style="position: relative; height:auto; width:100%">
    <canvas id="{{ $chartid }}"></canvas>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //var filename = "{{-- $filename --}}";
        addEventListener('load', (event) => {

            const labels = {!! json_encode($labels, JSON_INVALID_UTF8_IGNORE) !!};
            const mydata = {!! json_encode($data, JSON_INVALID_UTF8_IGNORE) !!};


            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First Dataset',
                    //data: [65, 59, 80, 81, 56, 55, 40],
                    data: mydata,
                    /*
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    */
                    borderWidth: 1
                }]
            };


            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        /*onComplete: function() {
                            axios.post('/chart/image/store', {
                                    filename: filename,
                                    content: myChart.toBase64Image()
                                })
                                .then(res => {
                                    console.log(res)
                                })
                                .catch(err => {
                                    console.log(err)
                                });
                        }*/
                    }
                },
            };

            const myChart = new Chart(
                document.getElementById('{{ $chartid }}'),
                config
            );
        });
    </script>
@endpush
