<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\ChartData;
use Modules\Quaeris\Datas\QuestionData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class GetChartImgAction {
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @param DataCollection<AnswerData> $answers
     */
    public function execute(DataCollection $answers, ChartData $chart, ?QuestionData $question = null): string {
        $engine_type = $chart->engine_type ?? 'JpGraph';
        $engine = __NAMESPACE__.'\Get'.$engine_type.'ImgAction';
        $res = app($engine)->execute($answers, $chart, $question);

        return $res;
    }
}
