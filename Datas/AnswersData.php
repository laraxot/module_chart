<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AnswersData extends Data {
    public int $tot = 0;
    public string $title = 'no_set';
    public string $footer = 'no_set';
    // public string $type = '';
    /**
     *  @var DataCollection<AnswerData>
     */
    public DataCollection $answers;

    public ChartData $chart;

    public function getChartJsType():string{
        $type = $this->chart->type;
        switch ($type) {
            case 'pieAvg': // questa è una media ha un solo valore
                $type = 'doughnut';
                break;
            case 'horizbar1':
                $type = 'bar';
                break;
            case 'pie1':
                $type = 'doughnut';
                break;
            case 'lineSubQuestion':
                $type = 'line';
                break;
            case 'bar2':
                $type = 'bar';
                break;
            case 'bar1':
                $type = 'bar';
                break;
            case 'bar3':
                $type = 'bar';
                break;

            default:
                dddx([
                    'type'=>$type,
                    'chart'=>$this->chart,
                ]);
                break;
        }

        return $type;

    }

    public function getChartJsData(): array{
        $datasets=[];
        $data = $this->answers->toCollection()->pluck('value')->all();

        if(in_array($this->chart->type ,['pieAvg', 'pie1'])){
            $data = $this->answers->toCollection()->pluck('avg')->all();

            if (isset($this->chart->max)) {
                $sum = collect($data)->sum();
                $other = $this->chart->max - $sum;
                if ($other > 0.01) {
                    $data[] = $other;
                    $labels[] = $this->chart->answer_value_no_txt ?? 'answer_value_no_txt';
                    if (2 === \count($labels) && \strlen((string) $labels[0]) < 3) {
                        $labels[0] = $this->chart->answer_value_txt;
                    }
                }
            }
        }

        // if(in_array($this->chart->type ,['bar2'])){
        //     dddx($this->answers);
        //     // dddx($this->answers->toCollection()->pluck('avg')->all());
        // }

        if (isset($data[0]) && is_array($data[0])) { // questionario multiplo
            // dddx([$this->chart, $this->answers]);
            $legends = array_keys($data[0]);
            foreach($legends as $key => $legend){
                $tmp = [
                    'label' => $legend,
                    'data' => array_column($data, $legend),
                    'borderColor' => $this->chart->getColorsRgba(0.2)[$key] ?? null,
                    'backgroundColor' => $this->chart->getColorsRgba(0.2)[$key] ?? null,
                ];
                $datasets[] = $tmp;

            }
        }else{
            $datasets = [
                [
                    'label' => ['Percentuale'],
                    'data' => $data,
                    'borderColor' => $this->chart->getColorsRgba(0.2),
                    'backgroundColor' => $this->chart->getColorsRgba(0.2),

                ],
            ];
        }


        $setup = [
            'datasets' => $datasets,
            'labels' => $this->answers->toCollection()->pluck('label')->all(),
            // 'labels' => ['tasso'],
        ];
        // dddx($setup);
        return $setup;
    }

    public function getChartJsOptions(): array {
        $legend_display = true;
        $title = [];

        if($this->title != 'no_set'){
            $title = [
                'display' => true,
                'text' => $this->title,
                'font' => [
                    'size' => 14,
                ],
            ];
        }

        if($this->footer != 'no_set'){
            $title = [
                'display' => true,
                'text' => $this->footer,
                'position' => 'bottom'
            ];
        }

        $options['plugins'] = [
                    'title' => $title,
                ];

        if(in_array($this->chart->type ,['horizbar1'])){
            $options['indexAxis'] = 'y';
        }

        // $options['plugins']['tooltip']['title'] = [
        //     'display' => true,
        //     // 'title' => 'prova',
        //     'text' => 'provaaaa',
        // ];



        // dddx($options);
        return $options;

        // var options = {
        //     tooltips: {
        //             callbacks: {
        //                 label: function(tooltipItem) {
        //                     return "$" + Number(tooltipItem.yLabel) + " and so worth it !";
        //                 }
        //             }
        //         },
        //             title: {
        //                       display: true,
        //                       text: 'Ice Cream Truck',
        //                       position: 'bottom'
        //                   },
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero:true
        //                     }
        //                 }]
        //             }
        //     };




        // [plugins: [{
        //     id: "centerText"
        //     , afterDatasetsDraw(chart, args, options) {
        //         const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

        //         ctx.save();

        //         var fontSize = width * 4.5 / 100;
        //         var lineHeight = fontSize + (fontSize * {{$take}} / 100);

        //         ctx.font = "bolder " + fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("{{$average}}", width / 2, (height / 2 + top - (lineHeight)));
        //         ctx.restore();

        //         ctx.font = fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("MEDIA", width / 2, (height / 2 + top) + fontSize - lineHeight);
        //         ctx.restore();

        //         ctx.font = fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("COMPLESSIVA", width / 2, (height / 2 + top) + fontSize);
        //         ctx.restore();
        //     }
        // }]]









    }

}
