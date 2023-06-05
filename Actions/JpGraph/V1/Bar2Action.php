<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Bar2Action {
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph {
        $data = $answers->toCollection()->pluck('avg')->all();
        $data1 = $answers->toCollection()->pluck('value')->all();

        $labels = $answers->toCollection()->pluck('label')->all();

        $graph = app(GetGraphAction::class)->execute($chart);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
        $graph->yscale->ticks->SupressZeroLabel(false);

        $graph->xaxis->SetTickLabels($labels) + 10;

        $bplot = new BarPlot($data);
        // $bplot = $this->applyPlotStyle($bplot);
        $bplot = app(ApplyPlotStyleAction::class)->execute($bplot, $chart);

        $colors = [];

        foreach ($labels as $k => $label) {
            if ('NR' == $label) {
                $colors[$k] = $chart->getColors()[1].'@'.$chart->transparency;
            } else {
                $colors[$k] = $chart->getColors()[0].'@'.$chart->transparency;
            }
        }
        $bplot->SetFillColor($colors); // trasparenza, da 0 a 1

        $graph->Add($bplot);

        $delta = ($chart->width - 100) / \count($data1);
        foreach ($data1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * $i) + ($delta / 3);

            $txt->SetPos($x, 25);

            $graph->AddText($txt);
        }

        return $graph;
    }
}
