<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class GetGraphAction {
    use QueueableAction;

    public function execute(ChartData $data): Graph {
        $graph = new Graph($data->width, $data->height, 'auto');
        $graph->SetScale('textlin');
        $graph->SetShadow();
        $theme_class = new UniversalTheme();

        $graph->SetTheme($theme_class);

        if (isset($data->min)) {
            $graph->yscale->SetAutoMin($data->min);
        }
        if (isset($data->max)) {
            $graph->yscale->SetAutoMax($data->max);
        }

        if (isset($data->title)) {
            $graph->title->Set($data->title);
            $graph->title->SetFont($data->font_family, $data->font_style, 11);
        }
        if (isset($data->subtitle)) {
            $graph->subtitle->Set($data->subtitle);
            $graph->subtitle->SetFont($data->font_family, $data->font_style, 11);
        }
        if (isset($data->footer)) {
            $graph->footer->center->Set($data->footer);
            $graph->footer->center->SetFont($data->font_family, $data->font_style, 10);
        }

        $graph->SetBox($data->show_box);

        $graph->footer->right->SetFont($data->font_family, $data->font_style);

        $this->applyGraphXStyle($graph->xaxis, $data);
        $this->applyGraphYStyle($graph->yaxis, $data);

        return $graph;
    }

    public function applyGraphXStyle(Axis $xaxis, ChartData $data): void {
        $xaxis->SetFont($data->font_family, $data->font_style, $data->font_size);
        $xaxis->SetLabelAngle($data->x_label_angle);
        // Some extra margin looks nicer
        $xaxis->SetLabelMargin($data->x_label_margin);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle(Axis $yaxis, ChartData $data): void {
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        $yaxis->scale->SetGrace($data->y_grace);
        // dddx($style['yaxis_hide']);
        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        if (null == $data->yaxis_hide || 0 == $data->yaxis_hide) {
            $yaxis->Hide();
        }

        $yaxis->HideZeroLabel();
        $yaxis->HideLine(false);
        $yaxis->HideTicks(false, false);
    }
}
