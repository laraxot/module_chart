<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Plot\BarPlot;
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
        //$graph->title->set('Media Giudizi');
        //$graph->img->SetMargin(60, 20, 35, 75);
        $graph->SetScale('textlin', 5, 10);
        //$graph->SetScale('lin', 5, 10);
        //$graph->SetY2Scale('lin', 0, 10);
        $graph->SetY2Scale('int', 5, 10);
        $graph->SetY2OrderBack(false);

        $graph->SetMarginColor('lightblue:1.1');
        $graph->SetShadow();

        $theme_class = new UniversalTheme();
        $graph->SetTheme($theme_class);

        // Set up the title for the graph
        //$graph->title->Set('Bar gradient with left reflection');
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
        //$bplot->SetFillGradient('navy:0.9', 'navy:1.85', GRAD_LEFT_REFLECTION);
        $bplot->SetFillColor('darkgreen');

        // Set color for the frame of each bar
        $bplot->SetColor('white');

        //----------------------------------------------------------------
        // Setup values
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        $bplot->value->Show();
        $bplot->value->setColor('white');
        $bplot->value->setAngle(50);
        $bplot->value->SetFormat('%01.2f');
        //$bplot->value->SetFont(FF_FONT1, FS_BOLD);
        $bplot->value->SetFont(FF_VERDANA, FS_ITALIC);
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_listfontsex1.html
        $bplot->value->SetFont(FF_ARIAL, FS_BOLD);

        // Center the values in the bar
        $bplot->SetValuePos('center');

        // Make the bar a little bit wider
        $bplot->SetWidth(0.7);
        //----------------------------------------------------------------

        $graph->Add($bplot);

        //line1
        $data6y = [7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5];

        $lplot = new LinePlot($data6y);

        $graph->AddY2($lplot);

        $lplot->SetBarCenter();
        $lplot->SetColor('navy');
        $lplot->SetLegend('Riferimento '.$this->width);
        //$lplot->mark->SetType(MARK_X, '', 1.0);
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
            //$txt->SetColor('red');
            //$txt->SetFont(FF_FONT2, FS_BOLD);

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
        //------------------------------
        //$this->vars['title']

        $this->graph = $graph;

        return $this;
    }

    public function bar2_old(): self {
        //dddx($this->vars);
        // We need some data
        $datax = $this->data->pluck('label')->all();
        $datay = $this->data->pluck('value')->all();
        $datax1 = $this->data->pluck('value1')->all();

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

        //----------------------------------------------------------------
        // Setup values
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        //se tolto non mostra i valori
        $bplot->value->Show();

        //colore del font che scrivi
        $bplot->value->setColor('white');

        //da fare
        //plot_value_color
        //plot_value_show
        //plot_value_format
        //plot_value_pos

        //$bplot->value->setAngle(50);
        $bplot->value->SetFormat('%01.2f');

        // Center the values in the bar
        $bplot->SetValuePos('center');

        // Make the bar a little bit wider
        //$bplot->SetWidth(0.9);
        //----------------------------------------------------------------

        $graph->Add($bplot);

        $delta = ($this->width - 100) / count($datax1);
        $delta = $delta;
        foreach ($datax1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * ($i)) + ($delta / 3);

            $txt->SetPos($x, 25);

            $graph->AddText($txt);
        }
        $this->graph = $graph;

        return $this;
    }

    public function bar2(): self {
        // We need some data
<<<<<<< HEAD

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
=======
        $datax = $this->data->pluck('label')->all();
        $datay = $this->data->pluck('value')->all();
        $datax1 = $this->data->pluck('value1')->all();
>>>>>>> 794c09d (first)
        //dddx($this->data->pluck('A1')->all());
        //dddx([$this->vars]);
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

        //----------------------------------------------------------------
        // Setup values
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        //se tolto non mostra i valori
        //$bplot->value->Show();

        //colore del font che scrivi
        //$bplot->value->setColor('white');

        //$bplot->value->setAngle(50);
        //$bplot->value->SetFormat('%01.2f');

        // Center the values in the bar
        //$bplot->SetValuePos('center');

        // Make the bar a little bit wider
        //$bplot->SetWidth(0.9);
        //----------------------------------------------------------------

        $graph->Add($bplot);

        $delta = ($this->width - 100) / count($datax1);
        $delta = $delta;
        foreach ($datax1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * ($i)) + ($delta / 3);

            $txt->SetPos($x, 25);

            $graph->AddText($txt);
        }

        //dddx(collect($datay));
        $avg = round(collect($datay)->avg(), 2);
        $tmp = array_fill(0, count($datay) - 1, '-');
        $tmp = array_merge([$avg], $tmp, [$avg]);
        //dddx($tmp);

        //linea della media
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

        //https://jpgraph.net/download/manuals/chunkhtml/ch14s04.html
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
}
