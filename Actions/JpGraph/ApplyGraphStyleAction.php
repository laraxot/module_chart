<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class ApplyGraphStyleAction {
    use QueueableAction;

    public function execute(Graph &$graph, ChartData $chart):Graph {
        // Nice shadow
        $graph->SetShadow();

        $graph->SetBox($chart->show_box);

        $graph->footer->right->SetFont($chart->font_family, $chart->font_style);
        // $graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);
        if (null != $graph->xaxis) {
            $this->applyGraphXStyle($graph->xaxis, $chart);
        }
        if (null != $graph->yaxis) {
            $this->applyGraphYStyle($graph->yaxis, $chart);
        }

        return $graph;
    }

    public function applyGraphXStyle(Axis &$xaxis, ChartData $data): void {
        $xaxis->SetFont($data->font_family, $data->font_style, $data->font_size);
        $xaxis->SetLabelAngle($data->x_label_angle);
        // Some extra margin looks nicer
        $xaxis->SetLabelMargin($data->x_label_margin);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle(Axis &$yaxis, ChartData $data): void {
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        $yaxis->scale->SetGrace($data->y_grace);
        // dddx($style['yaxis_hide']);
        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        // if (null == $data->yaxis_hide || 0 == $data->yaxis_hide) {
        if ($data->yaxis_hide) {
            $yaxis->Hide();
        }

        $yaxis->HideZeroLabel();
        $yaxis->HideLine(false);
        $yaxis->HideTicks(false, false);
    }
}
