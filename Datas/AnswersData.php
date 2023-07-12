<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

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
                dddx($type);
                break;
        }

        return $type;

    }

    public function getChartJsData(): array{
        // $colors = explode(',', $this->chart->list_color);
        // dddx($this->answers->toCollection()->pluck('label')->all());

        $colors = "rgba(255, 99, 132, 1)";

        if(in_array($this->chart->type ,['pieAvg', 'pie1'])){
            $data = $this->answers->toCollection()->pluck('avg')->all();
            $colors = ["rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)"];
        }else{
            $data = $this->answers->toCollection()->pluck('value')->all();
        }

        $setup = [
            'datasets' => [
                [
                    'label' => 'aaa',
                    'data' => $data,
                    'borderColor' => $colors,
                    'backgroundColor' => $colors,
                    
                ],
            ],
            'labels' => $this->answers->toCollection()->pluck('label')->all(),
        ];

        return $setup;
    }

    public function getChartJsOptions(): array {
        $legend_display = true;
        if(!in_array($this->chart->type ,['pie1'])){
            $legend_display = false;
        }

        $options['plugins'] = [
                    'legend' => [
                        'display' => $legend_display,
                    ]
                ];

        if(in_array($this->chart->type ,['horizbar1'])){
            $options['indexAxis'] = 'y';
        }
        // dddx($options);
        return $options;

    }

}
