<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Illuminate\Support\Str;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Horizbar1Action {
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph {
        $data = $answers->toCollection()->pluck('value')->all();

        $labels = $answers->toCollection()->pluck('label')->all();

        // dddx(['data' => $data, 'labels' => $labels, 'chart' => $chart]);
        $data = collect($data)->map(function ($item) {
            if (is_array($item)) {
                return array_values($item)[0];
            }

            return $item;
        })->all();

        /*
        $tmp = [];
        if (null !== $chart->sublabels) {
            dddx([$answers, $chart->sublabels]);
            if (count($chart->sublabels) > 0) {
                $i = 0;
                foreach ($chart->sublabels as $k => $v) {
                    $tmp[$i++] = collect($data)->sum($k);
                }
                $labels = array_values($chart->sublabels);
                $data = $tmp;
            }
        }
        */

        // dddx([$labels, $data]);
        // if (isset($this->vars['names']) && \is_array($this->vars['names']) && '' !== $this->vars['group_by']) {
        //     // dddx($this->vars['names']);
        //     $labels = array_values($this->vars['names']); // 4 debug
        // }

        // dddx([$this->data, $this->data->pluck('label')->all(), $this->vars['names'], $this->vars['group_by']]);

        // Set the basic parameters of the graph
        // $graph = $this->getGraph();
        $graph = app(GetGraphAction::class)->execute($chart);

        $graph->SetScale('textlin');

        // Rotate graph 90 degrees and set margin
        $graph->Set90AndMargin(250, 20, 50, 30);

        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // a true inserisce un bordo in più
        // $graph->SetFrame(true, 'green', 5);

        // a false elimina il bordo del grafico
        // $graph->SetBox(false);

        // $this->applyGraphXStyle($graph->xaxis);
        // $this->applyGraphYStyle($graph->yaxis);

        // Setup title
        // https://jpgraph.net/download/manuals/chunkhtml/ch14s02.html
        // dddx($this->vars['mandatory']);
        /*
        $mandatory = $data->mandatory;
        if (null === $data->mandatory) {
            $mandatory = 'null';
        }
        */
        // $title = $this->vars['title'];
        // $graph->title->Set($title);
        // $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        // Setup X-axis
        $graph->xaxis->SetTickLabels($labels) + 10;

        // $graph->xaxis->SetLabelAngle($this->vars['style']['x_label_angle']);

        // Some extra margin looks nicer
        // $graph->xaxis->SetLabelMargin(10);

        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');

        // Now create a bar pot
        $bplot = new BarPlot($data);
        // $bplot = $this->applyPlotStyle($bplot);
        $bplot = app(ApplyPlotStyleAction::class)->execute($bplot, $chart);

        // per mettere il colore diverso alla label NR, ma qui non va bene
        // if (Str::contains($chart->type, 'horiz')) {
        $colors = [];
        // dddx(['data' => $data, 'labels' => $labels, 'chart' => $chart]);
        foreach ($labels as $k => $label) {
            if ('NR' == $label) {
                $colors[$k] = $chart->getColors()[1].'@'.$chart->transparency;
            } else {
                $colors[$k] = $chart->getColors()[0].'@'.$chart->transparency;
            }
        }
        $bplot->SetFillColor($colors); // trasparenza, da 0 a 1
        // }

        // Add the bar to the graph
        $graph->Add($bplot);

        return $graph;
    }
}
