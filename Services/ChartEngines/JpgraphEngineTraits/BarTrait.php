<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Text\Text;
use Amenadiel\JpGraph\Themes\UniversalTheme;

trait BarTrait {
    /**
     * Undocumented function.
     */
    public function bar1(): self {
        // We need some data
        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();
        $datax1 = $this->data->pluck('count')->all();

        // Setup the graph.

        $graph = $this->getGraph();
        // $graph->title->set('Media Giudizi');
        // $graph->img->SetMargin(60, 20, 35, 75);
        $graph->SetScale('textlin', 5, 10);
        // $graph->SetScale('lin', 5, 10);
        // $graph->SetY2Scale('lin', 0, 10);
        $graph->SetY2Scale('int', 5, 10);
        $graph->SetY2OrderBack(false);

        $graph->SetMarginColor('lightblue:1.1');
        $graph->SetShadow();

        $theme_class = new UniversalTheme();
        $graph->SetTheme($theme_class);

        // Set up the title for the graph
        // $graph->title->Set('Bar gradient with left reflection');
        $graph->title->SetMargin(8);
        $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 12);
        $graph->title->SetColor('darkred');

        // Setup font for axis
        $graph->xaxis->SetFont($this->vars['font_family'], $this->vars['font_style'], 10);
        $graph->yaxis->SetFont($this->vars['font_family'], $this->vars['font_style'], 10);

        // Show 0 label on Y-axis (default is not to show)
        $graph->yscale->ticks->SupressZeroLabel(false);

        // Setup X-axis labels
        $graph->xaxis->SetTickLabels($datax);
        $graph->xaxis->SetLabelAngle($this->vars['x_label_angle']);

        // Create the bar pot
        $bplot = new BarPlot($datay);
        $bplot->SetWidth(0.6);

        // Setup color for gradient fill style
        // $bplot->SetFillGradient('navy:0.9', 'navy:1.85', GRAD_LEFT_REFLECTION);
        $bplot->SetFillColor('darkgreen');

        // Set color for the frame of each bar
        $bplot->SetColor('white');

        // ----------------------------------------------------------------
        // Setup values
        // http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        $bplot->value->Show();
        $bplot->value->setColor('white');
        $bplot->value->setAngle(50);
        $bplot->value->SetFormat('%01.2f');
        // $bplot->value->SetFont(FF_FONT1, FS_BOLD);
        $bplot->value->SetFont(FF_VERDANA, FS_ITALIC);
        // http://www.digialliance.com/docs/jpgraph/html/exframes/frame_listfontsex1.html
        $bplot->value->SetFont(FF_ARIAL, FS_BOLD);

        // Center the values in the bar
        $bplot->SetValuePos('center');

        // Make the bar a little bit wider
        $bplot->SetWidth(0.7);
        // ----------------------------------------------------------------

        $graph->Add($bplot);

        // line1
        $data6y = [7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5];

        $lplot = new LinePlot($data6y);

        $graph->AddY2($lplot);

        $lplot->SetBarCenter();
        $lplot->SetColor('navy');
        $lplot->SetLegend('Riferimento '.$this->width);
        // $lplot->mark->SetType(MARK_X, '', 1.0);
        $lplot->mark->SetWeight(12);
        $lplot->mark->SetWidth(18);
        $lplot->mark->setColor('yellow');
        $lplot->mark->setFillColor('yellow');

        $delta = $this->width / count($datax1);
        $delta = $delta - 1;
        foreach ($datax1 as $i => $v) {
            $txt = new Text($v.'');

            // Position the string at absolute pixels (0,20).
            // ( (0,0) is the upper left corner )
            $txt->SetPos(55 + ($delta * $i), 70);

            // Set color and fonr for the text
            // $txt->SetColor('red');
            // $txt->SetFont(FF_FONT2, FS_BOLD);

            // ... and add the text to the graph
            $graph->AddText($txt);
        }
        /*
        // Finally send the graph to the browser
        if (File::exists(public_path($this->filename))) {
            File::delete(public_path($this->filename));
        }

        $graph->Stroke($this->filename);
        */
        // ------------------------------
        // $this->vars['title']

        $this->graph = $graph;

        return $this;
    }

    public function bar2_funzionante(): self {
        // We need some data

        $datax = $this->data->pluck('label')->all();
        $datay = $this->data->pluck('value')->all();
        $datax1 = $this->data->pluck('value1')->all();
        /*
        dddx([
            'data' => $this->data,
            'label' => $datax,
            'value' => $datay,
        ]);
         */
        // dddx($this->data->pluck('A1')->all());
        // dddx([$this->vars]);
        // Setup the graph.
        $graph = $this->getGraph();

        $graph->img->SetMargin(50, 50, 50, 100);

        // Show 0 label on Y-axis (default is not to show)
        $graph->yscale->ticks->SupressZeroLabel(false);

        // Setup X-axis labels
        $graph->xaxis->SetTickLabels($datax);
        $graph->xaxis->SetLabelAngle($this->vars['x_label_angle']);

        // Create the bar pot
        $bplot = new BarPlot($datay);

        $bplot = $this->applyPlotStyle($bplot);

        // ----------------------------------------------------------------
        // Setup values
        // http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        // se tolto non mostra i valori
        // $bplot->value->Show();

        // colore del font che scrivi
        // $bplot->value->setColor('white');

        // $bplot->value->setAngle(50);
        // $bplot->value->SetFormat('%01.2f');

        // Center the values in the bar
        // $bplot->SetValuePos('center');

        // Make the bar a little bit wider
        // $bplot->SetWidth(0.9);
        // ----------------------------------------------------------------

        $graph->Add($bplot);

        $delta = ($this->width - 100) / count($datax1);
        $delta = $delta;
        foreach ($datax1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * $i) + ($delta / 3);

            $txt->SetPos($x, 25);

            $graph->AddText($txt);
        }

        $avg = collect($datay)->avg();
        if (! is_numeric($avg)) {
            $avg = 0;
        }

        $avg = round($avg * 1, 2);
        $tmp = array_fill(0, count($datay) - 1, '-');
        $tmp = array_merge([$avg], (array) $tmp, [$avg]);
        // dddx($tmp);

        // linea della media
        /*
        $lplot = new LinePlot($tmp);
        $lplot->SetStyle('dotted'); //tipo di linea
        //$lplot->SetStyle('dashed'); //tipo di linea
        $lplot->SetWeight(2); //spessore della linea inserita
        $lplot->SetColor('red');
        $lplot->value->Show();
        $lplot->value->SetAlign('center');
        //dddx(get_class_methods($lplot->value));
        //$lplot->SetLegend('media: '.$avg); //mette la legenda sotto il grafico
        //$graph->legend->SetFrameWeight(1); //mette un bordo intorno alla legenda
        //$graph->legend->SetPos(0.58, 0.98, 'center', 'bottom');
        //$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
        $graph->legend->SetLayout(LEGEND_VERT);
        $graph->Add($lplot);
        */

        // https://jpgraph.net/download/manuals/chunkhtml/ch14s04.html
        /*
        $vars['extras'] = [
            (object) [
                'type' => 'horizontalLine',
                'y' => 7,
                'text' => 'riferimento',
            ],
        ];
        */
        /*
        $txt = new Text(''.$avg);
        //dddx($this->vars['height']);
        $height = $this->vars['height'] - 50;
        $y = $height - ($height * $avg / 100) - 20;
        //dddx($y);
        $txt->SetPos(80, $y);

        $graph->AddText($txt);
        */
        $this->graph = $graph;

        return $this;
    }

    public function bar2() {
        // dddx($this->vars);
        // https:// jpgraph.net/features/src/show-example.php?target=new_bar1.php
        $graph = $this->getGraph();
        $graph->img->SetMargin(50, 50, 50, 100);
        $labels = $this->data->pluck('label')->all();
        $datay = $this->data->pluck('value')->all();
        $datay1 = $this->data->pluck('value1')->all();

        // dddx($datay[0]);
        // dddx($datay1);
        // nel caso non ci siano risultati
        // gli do dei dati vuoti per fargli produrre un grafico vuoto
        if (! isset($datay[0])) {
            // dddx($datay1);
            // dddx('errore');
            $datay1 = [0 => 0];
            $datay[0] = [0 => 0];
            $datay[1] = [1 => 0];
            // dddx($datay[0]);
        }

        if (! is_array($datay[0])) {
            $datay = [$datay];
        } else {
            $tmp = [];
            foreach ($datay as $arr) {
                foreach ($arr as $k => $v) {
                    $tmp[$k][] = $v;
                }
            }
            $datay = $tmp;
        }
        // dddx(array_flip($datay));

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($this->vars['x_label_angle']);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->yscale->ticks->SupressZeroLabel(false);

        // Create the bar plots
        $colors = explode(',', $this->vars['list_color']);
        $bplot = [];

        foreach ($datay as $k => $v) {
            $tmp = new BarPlot($v);
            $tmp = $this->applyPlotStyle($tmp);
            $tmp->SetColor('white');
            $tmp->SetFillColor($colors[$k]);

            // $tmp->SetLegend("Houses"); //qui gli posso mettere la legenda, ma come?
            if (isset($this->vars['legend'])) {
                $str = $this->vars['legend'][$k] ?? '--no set';
                $tmp->SetLegend($str);
            }

            $bplot[] = $tmp;
        }

        // Create the grouped bar plot
        $gbplot = new GroupBarPlot($bplot);
        // ...and add it to the graPH
        $graph->Add($gbplot);

        // dddx($this->vars['tot']);
        // dddx([count($datay), $labels, $datay, $datay1]);
        /*
        if (! isset($datay[0])) {
            unset($this->vars['tot']);
            // dddx([$this->vars]);
        }
        */

        // dddx(get_defined_vars());

        if (count($datay) > 1) {
            // dddx($this->data->first()['title_type']);
            // dddx($this->vars['title']);
            $title = $this->vars['title'];

            // $subtitle = 'Totale rispondenti';
            $graph->title->Set($title);
            $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }

        if (isset($this->vars['totali'])) {
            $str = '';
            foreach ($this->vars['totali'] as $k => $v) {
                $str .= $k.' '.$v.' - ';
            }
            $graph->footer->center->Set($str);
            $graph->footer->center->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }

        // if (isset($this->vars['tot'])) {
        // if (array_key_exists('tot', $this->vars)) {
        // if (! isset($datay[1])) {
        /*
        if (count($datay) > 1) {
            $subtitle = 'Totale Rispondenti '.$this->vars['tot']; // .' - ('.$mandatory.')';
            if ('Y' != $this->vars['mandatory']) {
                if (isset($this->vars['tot_nulled'])) {
                    $subtitle .= ' Non rispondenti '.$this->vars['tot_nulled'];
                }
            }
            $graph->subtitle->Set($subtitle);
            $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        } else {
            dddx($this->vars);
            $subtitle = 'testo di prova';
            $graph->subtitle->Set($subtitle);
            $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }
        */

        // cifre sopra il grafico
        $delta = ($this->width - 100) / count($datay1);
        $delta = $delta;
        foreach ($datay1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * $i) + ($delta / 3);

            $txt->SetPos($x, 25);

            // dddx($txt);

            $graph->AddText($txt);
        }

        $this->graph = $graph;

        return $this;
    }
}
