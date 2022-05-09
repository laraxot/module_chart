<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;

trait HorizbarTrait {
    //-------------------
    public function horizbar1(): self {
<<<<<<< HEAD

        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();



        if (isset($this->vars['names']) && is_array($this->vars['names']) && '' != $this->vars['group_by']) {
            //dddx($this->vars['names']);
            $datax = array_values($this->vars['names']); //4 debug
        }

        //dddx([$this->data, $this->data->pluck('label')->all(), $this->vars['names'], $this->vars['group_by']]);

=======
        //dddx($this->data);
        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();
        if (isset($this->vars['names']) && is_array($this->vars['names'])) {
            $datax = $this->vars['names']; //4 debug
        }

>>>>>>> 5cd95fd (first)
        // Set the basic parameters of the graph
        $graph = $this->getGraph();
        $graph->SetScale('textlin');

        // Rotate graph 90 degrees and set margin
        $graph->Set90AndMargin(250, 20, 50, 30);

        // a true inserisce un bordo in più
        //$graph->SetFrame(true, 'green', 5);

        //a false elimina il bordo del grafico
        //$graph->SetBox(false);
        $graph = $this->applyGraphStyle($graph);

        $this->applyGraphXStyle($graph->xaxis);
        $this->applyGraphYStyle($graph->yaxis);

        // Setup title
        //https://jpgraph.net/download/manuals/chunkhtml/ch14s02.html
        if (isset($this->vars['tot'])) {
            $graph->subsubtitle->Set('Totale Rispondenti '.$this->vars['tot']);
            $graph->subsubtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }
        //$this->setTitle('aaaa');

        // Setup X-axis
        $graph->xaxis->SetTickLabels($datax) + 10;

        //$graph->xaxis->SetLabelAngle($this->vars['style']['x_label_angle']);

        // Some extra margin looks nicer
        //$graph->xaxis->SetLabelMargin(10);

        // Label align for X-axis
        //$graph->xaxis->SetLabelAlign('right', 'center');

        // Now create a bar pot
        $bplot = new BarPlot($datay);
        $bplot = $this->applyPlotStyle($bplot);

        // Add the bar to the graph
        $graph->Add($bplot);

<<<<<<< HEAD
=======
        //-----------------------------
        //$txt = new Text('Totale Risposte '.$this->vars['tot']);
        /*
        $txt = new Text();
        $txt->Set('Totale Risposte '.$this->vars['tot']);

        // Position the string at absolute pixels (0,20).
        // ( (0,0) is the upper left corner )
        $txt->SetPos(100, 10);

        // Set color and fonr for the text
        $txt->SetColor('red');
        $txt->SetFont($this->vars['style']['font_family'], $this->vars['style']['font_style']);

        // ... and add the text to the graph
        $graph->AddText($txt);
        */
        //------------------------------
        //$graph->footer->right->SetFont($this->vars['style']['font_family'], $this->vars['style']['font_style']);
        //$graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);
>>>>>>> 5cd95fd (first)

        $this->graph = $graph;

        return $this;
    }
}
