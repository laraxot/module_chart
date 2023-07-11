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

        if(in_array($this->chart->type ,['pieAvg', 'pie1'])){
            $data = $this->answers->toCollection()->pluck('avg')->all();
        }else{
            $data = $this->answers->toCollection()->pluck('value')->all();
        }

        $setup = [
            'datasets' => [
                [
                    'label' => '',
                    'data' => $data,
                ],
            ],
            'labels' => $this->answers->toCollection()->pluck('label')->all(),
        ];

        return $setup;
    }

}
