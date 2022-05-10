<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Plot\BarPlot;

trait HorizbarTrait {
    // -------------------
    public function horizbar1(): self {
        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();

        if (isset($this->vars['names']) && \is_array($this->vars['names']) && '' !== $this->vars['group_by']) {
            // dddx($this->vars['names']);
            $datax = array_values($this->vars['names']); // 4 debug
        }

        // dddx([$this->data, $this->data->pluck('label')->all(), $this->vars['names'], $this->vars['group_by']]);

        // Set the basic parameters of the graph
        $graph = $this->getGraph();
        $graph->SetScale('textlin');

        // Rotate graph 90 degrees and set margin
        $graph->Set90AndMargin(250, 20, 50, 30);

        // a true inserisce un bordo in più
        // $graph->SetFrame(true, 'green', 5);

        // a false elimina il bordo del grafico
        // $graph->SetBox(false);
        $graph = $this->applyGraphStyle($graph);

        $this->applyGraphXStyle($graph->xaxis);
        $this->applyGraphYStyle($graph->yaxis);

        // Setup title
        // https://jpgraph.net/download/manuals/chunkhtml/ch14s02.html
        if (isset($this->vars['tot'])) {
            $graph->subsubtitle->Set('Totale Rispondenti '.$this->vars['tot']);
            $graph->subsubtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }
        // $this->setTitle('aaaa');

        // Setup X-axis
        $graph->xaxis->SetTickLabels($datax) + 10;

        // $graph->xaxis->SetLabelAngle($this->vars['style']['x_label_angle']);

        // Some extra margin looks nicer
        // $graph->xaxis->SetLabelMargin(10);

        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');

        // Now create a bar pot
        $bplot = new BarPlot($datay);
        $bplot = $this->applyPlotStyle($bplot);

        // Add the bar to the graph
        $graph->Add($bplot);

        $this->graph = $graph;

        return $this;
    }
}
