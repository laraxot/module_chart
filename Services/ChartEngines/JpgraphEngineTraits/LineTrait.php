<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\PlotLine;
use Illuminate\Support\Collection;

trait LineTrait {
    public function horizontalLine(float $y, string $string): self {
        // \define('HORIZONTAL', 0);
        $sline = new PlotLine(0, $y, 'black', 1);
        $this->graph->Add($sline);

        return $this;
    }

    public function line1(): self {
        // $datax = $this->data->pluck('label')->all();
        // Setup the graph.
        $n = \count($this->vars['names']);

        $graph = $this->getGraph();

        $datax = $this->data->pluck('label')->all();
        $datay = [];

        for ($i = 0; $i < $n; ++$i) {
            $datay[$i] = $this->data->pluck('datay'.$i)->all();
        }

        // Setup the graph

        $graph->SetScale('textlin');

        // $graph->SetMargin(40, 20, 33, 58);

        // $graph->title->Set('Background Image');
        $graph->SetBox(false);

        $this->applyGraphYStyle($graph->yaxis);
        $this->applyGraphXStyle($graph->xaxis);
        $graph->xaxis->SetTickLabels($datax);

        $graph->ygrid->SetFill(false);
        // $graph->SetBackgroundImage('tiger_bkg.png', BGIMG_FILLFRAME);
        $p = [];

        $colors_custom = explode(',', $this->vars['list_color']);
        $colors_default = [
            '#55bbdd',
            '#aaaaaa',
            '#d60021',
            '#0baa90',
        ];

        $colors = array_merge($colors_custom, $colors_default);
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
            $p[$i]->SetColor($colors[$i]);
            $p[$i]->SetLegend($this->vars['names'][$i]);
            $p[$i]->mark->SetType($marks[$i], '', 1.2);
            $p[$i]->mark->SetColor($colors[$i]);
            // $p[$i]->mark->SetFillColor($colors[$i].'@0.6'); // trasparenza da 0 a 1
            $p[$i]->mark->SetFillColor($colors[$i]);
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
        $graph->legend->SetColor('#4E4E4E', '#00A78A'); // prende il primo colore
        $graph->legend->SetMarkAbsSize(8);

        $this->graph = $graph;

        return $this;
    }

    public function lineSubQuestion(): self {
        // $datax = $this->data->pluck('label')->all();
        // Setup the graph.
        // $this->vars['names'] = ['A1', 'A2', 'A3', 'A4'];
        $names = $this->vars['names'];
        $n = \count($names);

        $graph = $this->getGraph();

        $datax = $this->data->pluck('label')->all();
        $datay = [];
        $values = $this->data->pluck('values');
        foreach ($values as $item) {
            /**
             * @var Collection
             */
            $v = $item;
            foreach ($names as $k1 => $v1) {
                $datay[$k1][] = $v->get($k1) ?? '-';
            }
        }
        $datay = array_values($datay);
        $names = array_values($names);

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
        $graph->xaxis->SetLabelAngle($this->vars['x_label_angle']);

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
            $p[$i]->SetColor($colors[$i]);
            $p[$i]->SetLegend($names[$i]);
            $p[$i]->mark->SetType($marks[$i], '', 1.2);
            $p[$i]->mark->SetColor($colors[$i]);
            // dddx($this->vars['transparency']);
            // $p[$i]->mark->SetFillColor($colors[$i].'@'.$this->vars['transparency']); // trasparenza da 0 a 1
            $p[$i]->mark->SetFillColor($colors[$i]);
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

        $title = $this->vars['title'];
        $graph->title->Set($title);
        $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        $subtitle = $this->vars['subtitle'];
        $graph->subtitle->Set($subtitle);
        $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        $graph->footer->center->Set('');

        $this->graph = $graph;

        return $this;
    }
}
