<div id="chart_div"></div>
<br />
<div id="btn-group">
    <button class="button button-blue" id="none">No Format</button>
    <button class="button button-blue" id="scientific">Scientific Notation</button>
    <button class="button button-blue" id="decimal">Decimal</button>
    <button class="button button-blue" id="short">Short</button>
</div>
@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses', 'Profit'],
                ['2014', 1000, 400, 200],
                ['2015', 1170, 460, 250],
                ['2016', 660, 1120, 300],
                ['2017', 1030, 540, 350]
            ]);

            var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                hAxis: {
                    format: 'decimal'
                },
                height: 400,
                colors: ['#1b9e77', '#d95f02', '#7570b3']
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));

            chart.draw(data, google.charts.Bar.convertOptions(options));

            var btns = document.getElementById('btn-group');

            btns.onclick = function(e) {

                if (e.target.tagName === 'BUTTON') {
                    options.hAxis.format = e.target.id === 'none' ? '' : e.target.id;
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            }

            console.log(chart.getImageURI());
        }
    </script>
@endpush
