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
                dddx($type);
                break;
        }

        return $type;

    }

    public function getChartJsData(): array{
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

        




        if (isset($data[0]) && is_array($data[0])) { // questionario multiplo
            $legends = array_keys($data[0]);
            foreach($legends as $legend){
                $tmp = [
                    'label' => $legend,
                    'data' => array_column($data, $legend),

                ];
                $datasets[] = $tmp;

            }
        }else{
            $datasets = [
                [
                    'label' => 'Rispondenti',
                    'data' => $data,
                    'borderColor' => $this->chart->getColorsRgba(1),
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

        if(!in_array($this->chart->type ,['pie1'])){
            $legend_display = false;
        }

        if($this->title != 'no_set'){
            $title = [
                'display' => true,
                'text' => $this->title,
                'font' => [
                    'size' => 14,
                ],
            ];
        }

        $options['plugins'] = [
                    // 'legend' => [
                    //     'display' => $legend_display,
                    // ],
                    'title' => $title,

                ];

        if(in_array($this->chart->type ,['horizbar1'])){
            $options['indexAxis'] = 'y';
        }
        // dddx($options);
        return $options;

    }

}
