<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class LineSubQuestionAction {
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph {
       
        //dddx([$answers,$chart->sublabels]);
        // dddx([$answers, $chart]);
        // $datax = $this->data->pluck('label')->all();
        // Setup the graph.
        // $this->vars['names'] = ['A1', 'A2', 'A3', 'A4'];
        // $names = $this->vars['names'];

        $n = \count($chart->sublabels);

        // $graph = $this->getGraph();
        $graph = app(GetGraphAction::class)->execute($chart);

        $datax = $answers->toCollection()->pluck('label')->all();
        $datay = [];
        // $values = $answers->toCollection()->pluck('value');
        // dddx([
        //     $answers->toCollection()->pluck('value'),
        //     $answers->toCollection()->pluck('values')->first(),
        // ]);

        /* -- MA PERCHE' !!!
        if (is_null($answers->toCollection()->pluck('values')->first())) {
            $values = $answers->toCollection()->pluck('value');
        } else {
            $values = $answers->toCollection()->pluck('values');
        }
        */
        $values = $answers->toCollection()->pluck('value');

        foreach ($values as $item) {
            /**
             * @var Collection
             */
            $v = $item;
            foreach ($chart->sublabels as $k1 => $v1) {
                $datay[$k1][] = collect($item)->get($k1) ?? '-';
            }
        }

        // dddx(['answers' => $answers, 'datay' => $datay]);

        $datay = array_values($datay);
        $names = array_values($chart->sublabels);

        // for ($i = 0; $i < $n; ++$i) {
        //    $datay[$i] = $this->data->pluck('datay'.$i)->all();
        // }

        // dddx(['DATA' => $this->data, 'Y' => $datay, 'X' => $datax]);

        // Setup the graph

        $graph->SetScale('textlin');

        // $graph->SetMargin(40, 20, 33, 58);

        // $graph->title->Set('Background Image');
        $graph->SetBox(false);

        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->xaxis->SetTickLabels($datax);
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

        for ($i = 0; $i < $n; ++$i) {
            $p[$i] = new LinePlot($datay[$i]);
            $graph->Add($p[$i]);
            // $p[$i]->SetColor($colors[$i]);
            $p[$i]->SetLegend($names[$i]);
            $p[$i]->mark->SetType($marks[$i], '', 1.2);
            // $p[$i]->mark->SetColor($colors[$i]);
            // dddx($this->vars['transparency']);
            // $p[$i]->mark->SetFillColor($colors[$i].'@'.$this->vars['transparency']); // trasparenza da 0 a 1
            // $p[$i]->mark->SetFillColor($colors[$i]);
            $p[$i]->SetCenter();
        }

        /*
        $p1 = new LinePlot($datay1);
        $graph->Add($p1);

        $p2 = new LinePlot($datay2);
        $graph->Add($p2);

        $p1->SetColor('#55bbdd');
        $p1->SetLegend('Line 1');
        $p1->mark->SetType(MARK_FILLEDCIRCLE, '', 1.0);
        $p1->mark->SetColor('#55bbdd');
        $p1->mark->SetFillColor('#55bbdd');
        $p1->SetCenter();

        $p2->SetColor('#aaaaaa');
        $p2->SetLegend('Line 2');
        $p2->mark->SetType(MARK_UTRIANGLE, '', 1.0);
        $p2->mark->SetColor('#aaaaaa');
        $p2->mark->SetFillColor('#aaaaaa');
        //$p2->value->SetMargin(14);
        $p2->SetCenter();
        */

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