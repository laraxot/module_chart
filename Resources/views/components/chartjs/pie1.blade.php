<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="chart-container" style="position: relative; height:auto; width:100%">
    <canvas id="{{ $chartid }}"></canvas>
</div>

<script src="{{ Theme::asset('adm_theme::dist/js/manifest.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/vendor.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    addEventListener('load', (event) => {

        const labels = {!! json_encode($labels, JSON_INVALID_UTF8_IGNORE) !!};
        const mydata = {!! json_encode($data, JSON_INVALID_UTF8_IGNORE) !!};

        const data = {
            labels: labels,
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                indexAxis: 'y',
                animation: {
                    onComplete: function() {
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
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('{{ $chartid }}'),
            config
        );

    });
</script>
