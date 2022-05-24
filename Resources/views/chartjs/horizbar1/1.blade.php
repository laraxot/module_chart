{{-- <x-chartjs.base type="horizbar1" /> --}}
@extends('chart::layouts.app')

@section('content')
    <div class="chart-container" style="position: relative; height:400px; width:700px">
        <canvas id="myChart"></canvas>
    </div>
@endsection

@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js'>
    </script>
    <script>
        // Label formatter function
        const formatter = (value, ctx) => {
            const otherDatasetIndex = ctx.datasetIndex === 0 ? 1 : 0;
            const total =
                ctx.chart.data.datasets[otherDatasetIndex].data[ctx.dataIndex] + value;

            return `${(value / total * 100).toFixed(0)}%`;
        };

        const data = [{
                // stack: 'test',
                label: "New",
                backgroundColor: "#1d3f74",
                data: [6310, 5742, 4044, 5564],
                // Change options only for labels of THIS DATASET
                datalabels: {
                    color: "white",
                    formatter: formatter
                }
            },
            {
                // stack: 'test',
                label: "Repeat",
                backgroundColor: "#6c92c8",
                data: [11542, 12400, 12510, 11450],
                // Change options only for labels of THIS DATASET
                datalabels: {
                    color: "yellow",
                    formatter: formatter
                }
            }
        ];

        const options = {
            maintainAspectRatio: false,
            spanGaps: false,
            responsive: true,
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#000",
                    boxWidth: 14,
                    fontFamily: "proximanova"
                }
            },
            tooltips: {
                mode: "label",
                callbacks: {
                    label: function(tooltipItem, data) {
                        const type = data.datasets[tooltipItem.datasetIndex].label;
                        const value =
                            data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        let total = 0;
                        for (let i = 0; i < data.datasets.length; i++)
                            total += data.datasets[i].data[tooltipItem.index];
                        if (tooltipItem.datasetIndex !== data.datasets.length - 1) {
                            return (
                                type + " : " + value.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "1,")
                            );
                        } else {
                            return [
                                type +
                                " : " +
                                value.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "1,"),
                                "Overall : " + total
                            ];
                        }
                    }
                }
            },
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: "#navy",
                    align: "center",
                    labels: {
                        title: {
                            font: {
                            weight: 'bold'
                            }
                        },
                        value: {
                            color: 'green'
                        }
                    }
                }
            },
            scales: {

                xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: "#navy"
                        }
                    },
                    {
                        type: 'category',
                        offset: true,
                        position: 'top',
                        ticks: {
                            fontColor: "#navy",
                            callback: function(value, index, values) {
                                return data[0].data[index] + data[1].data[index]
                            }
                        }
                    }
                ],
                yAxes: [{
                    stacked: true,
                    display: false,
                    ticks: {
                        fontColor: "#fff"
                    }
                }]
            }
        };

        const ctx = document.getElementById("myChart").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jun", "July", "Aug", "Sept"],
                datasets: data
            },
            options: options
        });
    </script>
@endpush
