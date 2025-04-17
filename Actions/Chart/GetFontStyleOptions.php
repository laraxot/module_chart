<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Chart;

use Modules\Chart\Datas\ChartData;
use Modules\Chart\Models\MixedChart;
use Modules\Quaeris\Datas\QuestionData;
use Spatie\QueueableAction\QueueableAction;

class GetFontStyleOptions
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(): array
    {
        return [
            9001 => 'FS_NORMAL',
            9002 => 'FS_BOLD',
            9003 => 'FS_ITALIC',
            // 9004 => 'FS_BOLDIT',
            9004 => 'FS_BOLDITALIC',
        ];
    }
}