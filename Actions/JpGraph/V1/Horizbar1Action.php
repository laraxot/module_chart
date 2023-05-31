<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Modules\Chart\Actions\JpGraph\ApplyGraphStyleAction;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Horizbar1Action
{
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph
    {
        $data = $answers->toCollection()->pluck('avg')->all();

        $labels = $answers->toCollection()->pluck('label')->all();
        /*
        $data = collect($data)->map(function ($item) {
            if (is_array($item)) {
                return array_values($item)[0];
            }

            return $item;
        })->all();
        */
        $graph = app(GetGraphAction::class)->execute($chart);

        $graph->SetScale('textlin');

        // Rotate graph 90 degrees and set margin
        $graph->Set90AndMargin(250, 20, 50, 30);

        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

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

        // Add the bar to the graph
        $graph->Add($bplot);

        return $graph;
    }
}
