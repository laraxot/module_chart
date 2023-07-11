<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AnswersChartData extends Data {
    /**
     * @var DataCollection<AnswerData>
     */
    public DataCollection $answers;

    public ChartData $chart;

    public function getChartJsData(): array{
        // dddx('a');
        $setup = [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    // 'data' => [0, rand(1,100), 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'data' => [5, 2],
                    // 'data' => $data,
                ],
            ],
            'labels' => ['Jan', 'Feb'],
        ];

        // dddx($setup);
        // foreach($this->answers as $answer){
        //     dddx($answer);
        // }


        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    // 'data' => [0, rand(1,100), 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'data' => [5, 2],
                    // 'data' => $data,
                ],
            ],
            'labels' => ['Jan', 'Feb'],
        ];
    }
}
