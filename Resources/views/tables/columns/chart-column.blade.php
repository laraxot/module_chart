<div style="width:100%">
    @php
    /*
        dddx([
            'this'=>get_class($this),
            'obj'=>get_class($obj),

            'get_Defined_vars'=>get_defined_vars(),
            ]);
             <pre>{{print_r($obj->getCachedData(),true)}}</pre>
            */
            
    @endphp
       
    <canvas
                x-data="{
                    chart: null,

                    init: function () {
                        let chart = this.initChart()
                       
                        $wire.on('updateChartData', async ({ data }) => {
                            chart.data = this.applyColorToData(data)
                            chart.update('resize')
                        })

                        $wire.on('filterChartData', async ({ data }) => {
                            chart.destroy()
                            chart = this.initChart(data)
                        })
                    },

                    initChart: function (data = null) {
                        data = data ?? {{ json_encode($obj->getCachedData()) }}
                        
                        return (this.chart = new Chart($el, {
                            type: '{{ $obj->getType() }}',
                            data: this.applyColorToData(data),
                            options: {{ json_encode($obj->getOptions()) }} ?? {},
                        }))
                    },

                    applyColorToData: function (data) {
                        data.datasets.forEach((dataset, datasetIndex) => {
                            if (! dataset.backgroundColor) {
                                data.datasets[datasetIndex].backgroundColor = getComputedStyle(
                                    $refs.backgroundColorElement,
                                ).color
                            }

                            if (! dataset.borderColor) {
                                data.datasets[datasetIndex].borderColor = getComputedStyle(
                                    $refs.borderColorElement,
                                ).color
                            }
                        })

                        return data
                    },
                }"
                wire:ignore
                @if ($maxHeight = $obj->getMaxHeight())
                    style="max-height: {{ $maxHeight }}"
                @endif
            >
                <span
                    x-ref="backgroundColorElement"
                    @class([
                        'text-gray-50',
                        'dark:text-gray-300' => config('filament.dark_mode'),
                    ])
                ></span>

                <span
                    x-ref="borderColorElement"
                    @class([
                        'text-gray-500',
                        'dark:text-gray-200' => config('filament.dark_mode'),
                    ])
                ></span>
            </canvas>
</div>
