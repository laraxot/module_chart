<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Chart;

use Modules\Chart\Datas\ChartData;
use Modules\Chart\Models\MixedChart;
use Modules\Quaeris\Datas\QuestionData;
use Spatie\QueueableAction\QueueableAction;

class GetTypeOptions {
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(): array {
        $options = [
            'pie1' => 'torta',
            'pieAvg' => 'torta con media',
            'horizbar1' => 'barre orizzontali',
            'horizbar2' => 'barre orizzontali accumulata',
            // 'horizbar3' => 'barre orizzontali con NR differente',
            'bar2' => 'barre verticali',
            'bar3' => 'barre verticali accumulata',
            'bar1' => 'bar1',
            'line1' => 'linea',
            'lineSubQuestion' => 'linea da usare con subquestion',
            // 'barYesNo' => 'barre si/no',
            // 'barNoYes' => 'barre no/si',
            // 'pieMonthBarWeekBar' => 'torta/mese/settimana',
            // 'pieMonthBarWeekBarSiNo' => 'torta/mese/settimana si/no',
            // 'pieMonthBarWeekBarNoSi' => 'torta/mese/settimana no/si',
            // 'lineHorizontalBar' => 'linea/barre orizzontali',
            // 'pieYesNo' => 'torta si/no',
            // 'pieNoYes' => 'torta no/si',
        ];

        $mixed = MixedChart::get()->pluck('name', 'id')->all();
        $data = [];
        foreach ($mixed as $k => $v) {
            $k1 = 'mixed:'.$k;
            $data[$k1] = 'mixed:'.$v;
        }
        $options = array_merge($options, $data);

        return $options;
       
    }
}
