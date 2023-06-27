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
}
