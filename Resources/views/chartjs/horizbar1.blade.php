<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="{{ Theme::asset('adm_theme::dist/js/manifest.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/vendor.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
    ];

    const data = {
        labels: labels, // valori sull'asse delle x
        datasets: [{
            label: 'My First dataset', // legenda(?) supra il grafico
            // colori delle barre, 
            // può essere anche un array con colori diversi, ogniuna per ogni barra
            backgroundColor: 'rgb(255, 99, 132)',
            //borderColor: 'rgb(100, 100, 100)', // colore bordo delle barre
            borderColor: '#fff',
            borderWith: 20,
            data: [0, 10, 5, 2, 20, 30, 45], // valori sull'asse y
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
