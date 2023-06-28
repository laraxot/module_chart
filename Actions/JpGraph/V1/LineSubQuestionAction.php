<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class LineSubQuestionAction
{
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph
    {
        $graph = app(GetGraphAction::class)->execute($chart);

        $labels = $answers->toCollection()->pluck('label')->all();
        $data = $answers->toCollection()->pluck('value')->all();
        $legends = collect(collect($data)->first())->keys()->all();

        $graph->SetScale('textlin');

        // $graph->SetMargin(40, 20, 33, 58);

        // $graph->title->Set('Background Image');
        $graph->SetBox(false);

        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);

        $graph->ygrid->SetFill(false);
        // $graph->SetBackgroundImage('tiger_bkg.png', BGIMG_FILLFRAME);
        $p = [];
        $colors = [
            '#55bbdd',
            '#aaaaaa',
            '#d60021',
            '#0baa90',
        ];
        $marks = [
            MARK_FILLEDCIRCLE, // A filled circle

            MARK_UTRIANGLE, // A triangle pointed upwards
            MARK_SQUARE, // A filled square
            MARK_DTRIANGLE, // A triangle pointed downwards
            MARK_DIAMOND, // A diamond
            MARK_CIRCLE, // A circle

            MARK_CROSS, // A cross
            MARK_STAR, // A star
            MARK_X, // An 'X'
            MARK_LEFTTRIANGLE, // A half triangle, vertical line to left (used as group markers for Gantt charts)
            MARK_RIGHTTRIANGLE, // A half triangle, vertical line to right (used as group markers for Gantt charts)
            MARK_FLASH, // A Zig-Zag vertical flash
        ];

        foreach ($legends as $i => $legend) {
            $tmp_data = array_column($data, $legend);
            $p[$i] = new LinePlot($tmp_data);
            $graph->Add($p[$i]);
            $p[$i]->SetColor($colors[$i]);

            $p[$i]->SetLegend($legend);
            $p[$i]->mark->SetType($marks[$i], '', 1.2);
            $p[$i]->mark->SetColor($colors[$i]);
            // dddx($this->vars['transparency']);
            // $p[$i]->mark->SetFillColor($colors[$i].'@'.$this->vars['transparency']); // trasparenza da 0 a 1
            // $p[$i]->mark->SetFillColor($colors[$i]);
            $p[$i]->SetCenter();
        }

        $graph->legend->SetFrameWeight(1);
        $graph->legend->SetColor('#4E4E4E', '#00A78A');
        $graph->legend->SetMarkAbsSize(8);

        $title = $chart->title;
        $graph->title->Set($title);
        $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        $subtitle = $chart->subtitle;
        $graph->subtitle->Set($subtitle);
        $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);

        $graph->footer->center->Set('');

        return $graph;
    }
}
