<div>
    <canvas id="{{ $graph_id }}" width="400" height="400"></canvas>
</div>
@push('scripts')
    <script>
        const ctx = document.getElementById('{{ $graph_id }}').getContext('2d');

        async function fetchData() {
            const url = "{{ $url }}";



            const options = {
                method: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': "application/json",
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                }
            }
            const test = await fetch('/api/intellinet', options);

            const response = await fetch(url, options);
            const data = await response.json();
            console.log(data);
            return data;
        }

        fetchData().then(data => {
            //myChart.config.data=data;
            //myChart.update();
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
