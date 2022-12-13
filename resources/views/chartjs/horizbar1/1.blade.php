

@php
use Illuminate\Support\Str;

$uuid = Str::uuid()->toString();
@endphp

    <div class="chart-container" style="position: relative; height:400px; width:700px">
        <canvas id="myChart_{{$uuid}}"></canvas>
    </div>


@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js'>
    </script>
    <script>

    var uuid=@json($uuid);

    console.log(uuid);
    //closure per poter ridichiarare poi i let per un altro grafico

    var make=function(){
        let rawData = @json($data);
        let rawLabels = @json($labels);


        let data = {
            labels: rawLabels,
            datasets: [{
                    label: 'Answers',
                    data: rawData.map((v)=>parseInt(v)),
                    borderColor: '#FF0000',
                    backgroundColor: '#00FFFF',
                }
            ]
        }

        let ctx = document.getElementById("myChart_"+uuid).getContext("2d");

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Horizontal Bar Chart'
                    }
                }
            },
        });
    }
    make();

    </script>
@endpush
