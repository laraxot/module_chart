<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Modules\Chart\Datas\ChartData;
use Modules\Quaeris\Datas\QuestionData;
use Spatie\QueueableAction\QueueableAction;

class GetChartImgAction {
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(ChartData $chart, QuestionData $question): string {
        $engine_type = $chart->engine_type ?? 'JpGraph';
        $engine = __NAMESPACE__.'\Get'.$engine_type.'ImgAction';
        $res = app($engine)->execute($chart, $question);

        return $res;
    }
}