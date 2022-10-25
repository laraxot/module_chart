<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Illuminate\Support\Str;
use Modules\Chart\Services\ChartJsBuilder;

trait LineTrait {
    public function line1(): self {
        /**
         * @phpstan-var view-string
         */
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
        ];

        // dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html; // se non mostro js non fa il salvataggio

        return $this;
    }

    public function lineSubQuestion(): self {
        $uuid = Str::uuid()->toString();
        $uuid = str_replace('-', '', $uuid);
        $uuid = substr($uuid, -8);

        $names = $this->vars['names'];
        $n = \count($names);

        // $graph = $this->getGraph();

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

        // dddx(['datay'=>$datay,'values'=>$values,'names'=>$names,'datax'=>$datax]);

        $names_length = \count($names);
        $datasets = [];
        for ($i = 0; $i < $names_length; ++$i) {
            $datasets[] = [
                'label' => $names[$i],
                'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                'data' => $datay[$i],
            ];
        }

        $chartjsbuilder = ChartJsBuilder::make();

        $chartjs = $chartjsbuilder
        // attenzione: rand andrà sostuito con un id univoco per il canvas
        // ho provato con uuid ma vedo che non funziona. forse troppo lungo
        ->name('c'.$uuid)
        // a seconda del type
        ->type('line')
        ->size(['width' => $this->vars['width'], 'height' => $this->vars['height']])
        ->labels($datax)
        ->datasets($datasets)
        ->options([
            'indexAxis' => 'x',
            'elements' => [
                'bar' => [
                    'borderWidth' => 2,
                ],
            ],
            'responsive' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Totale Rispondenti: '.$this->vars['tot'],
                ],
            ],
        ]);

        $view = 'chart::chartjs.example';
        $view_params = compact('chartjs');
        $view_params['view'] = $view;
        $view_params['filename'] = 'prova123';

        // dddx($view_params);
        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html;

        /*$graph->SetScale('textlin');
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
            $p[$i]->mark->SetFillColor($colors[$i]);
            $p[$i]->SetCenter();
        }

        $graph->legend->SetFrameWeight(1);
        $graph->legend->SetColor('#4E4E4E', '#00A78A');
        $graph->legend->SetMarkAbsSize(8);

        $this->graph = $graph;*/

        return $this;
    }
}
