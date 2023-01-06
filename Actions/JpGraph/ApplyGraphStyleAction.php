<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class ApplyGraphStyleAction {
    use QueueableAction;

    public function execute(Graph $graph, ChartData $chart) {
        // Nice shadow
        $graph->SetShadow();

        $graph->SetBox($chart->show_box);

        $graph->footer->right->SetFont($chart->font_family, $chart->font_style);
        // $graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);

        return $graph;
    }
}
