<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;

trait PieTrait {
    /**
     * Undocumented function.
     * https://jpgraph.net/download/manuals/chunkhtml/ch16.html.
     * https://jpgraph.net/download/manuals/chunkhtml/example_src/piecex2.html.
     */
    public function pie1(): self {
        $labels = $this->data->pluck('label')->all();
        $data = $this->data->pluck('value')->all();
        // dddx([$this->data, $data, $this->vars]);
        if (isset($this->vars['max'])) {
            $sum = collect($data)->sum();
            $other = $this->vars['max'] - $sum;
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $this->vars['answer_value_no_txt'];
                if (2 === \count($labels) && \strlen($labels[0]) < 3) {
                    $labels[0] = $this->vars['answer_value_txt'];
                }
            }
            // dddx($data);
        }

        // A new pie graph
        $graph = new PieGraph($this->width, $this->height, 'auto');
        // $graph = $this->getGraph();
        $graph = $this->applyGraphStyle($graph);
        // Specify margins since we put the image in the plot area
        // $graph->SetMargin(1, 1, 1, 1);
        // $graph->SetMarginColor('navy');
        // $graph->SetShadow(true);
        // Setup background
        // $graph->SetBackgroundImage('worldmap1.jpg', BGIMG_FILLPLOT);

        /*
        $graph->SetScale('textlin', 0, 65); A plot has an illegal scale. This could for example be that you are trying to use text auto scaling to draw a line plot with only one point or that the plot area is too small. It could also be that no input data value is numeric (perhaps only '-' or 'x')
        */

        // $graph->legend->SetPos(0.5, 0.97, 'center', 'bottom');
        // $graph->legend->SetColumns(3);

        // Setup title
        /*
        $graph->title->Set('Media Complessiva:');
        $graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
        $graph->title->SetMargin(8); // Add a little bit more margin from the top
        $graph->subtitle->SetFont(FF_ARIAL, FS_BOLD, 10);
        $graph->subtitle->Set('(common objects)');
        */

        // Create the pie plot
        $p1 = new PiePlotC($data);
        // $p1->SetSliceColors(['darkred', 'navy', 'lightblue', 'orange', 'gray', 'teal']);
        // dddx($this->vars);
        $p1->SetSliceColors(explode(',', $this->vars['list_color']));

        // Set size of pie
        // $p1->SetSize(0.32);
        // $p1->SetLegends(['Si (%1.1f%%)', 'No (%1.1f%%)']);
        $p1->SetLegends($labels);
        // $p1->SetLabels(['Si (%1.1f%%)', 'No (%1.1f%%)']);
        // $p1->setLabels($labels);

        // Enable and set policy for guide-lines. Make labels line up vertically
        $p1->SetGuideLines(true, false);
        $p1->SetGuideLinesAdjust(1.5);

        // Use percentage values in the legends values (This is also the default)
        $p1->SetLabelType(PIE_VALUE_PER);
        $p1->value->Show();

        $p1->SetMidSize(0.8);

        if (isset($this->vars['tot'])) {
            $subtitle = 'Totale Rispondenti '.$this->vars['tot'];
            /*if (isset($this->vars['tot_nulled'])) {
                $subtitle .= ' Non rispondenti '.$this->vars['tot_nulled'];
            }
            $p1->title->Set($subtitle);
            $p1->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
            */
            $graph->title->Set($subtitle);
            $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
            if (isset($this->vars['mandatory']) && 'Y' != $this->vars['mandatory']) {
                if (isset($this->vars['tot_nulled'])) {
                    $subtitle1 = 'Non rispondenti '.$this->vars['tot_nulled'];
                    $graph->subtitle->Set($subtitle1);
                    $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
                }
            }
        }

        // $p1->title->Set('Totale Rispondenti '.$this->vars['tot']);
        // $p1->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);

        // Label font and color setup
        $p1->value->SetFont(FF_ARIAL, FS_BOLD, 10);
        $p1->value->SetColor('black');

        // Setup the title on the center circle
        $p1->midtitle->Set('');
        $p1->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);
        $p1->value->SetFormat('%2.1f%%');

        // Set color for mid circle
        $p1->SetMidColor('white');

        // Use percentage values in the legends values (This is also the default)
        // $p1->scale->hide();
        // $p1->SetLabelType(PIE_VALUE_PER);

        // Add plot to pie graph
        $graph->Add($p1);

        $this->graph = $graph;

        return $this;
    }

    public function pieAvg(): self {
        $labels = $this->data->pluck('label')->all();

        $data = $this->data->pluck('value')->all();
        $color_array = explode(',', $this->vars['list_color']);
        if (isset($this->vars['max'])) {
            $sum = collect($data)->sum();
            $other = $this->vars['max'] - $sum;
            if ($other > 0.01) {
                $color_array[1] = 'white';
                $data[] = $other;
                $labels[] = $this->vars['answer_value_no_txt'] ?? 'answer_value_no_txt';
                if (2 === \count($labels) && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $this->vars['answer_value_txt'];
                }
            }
        }
        // dddx($data);

        // A new pie graph
        $graph = new PieGraph($this->width, $this->height, 'auto');
        $graph = $this->applyGraphStyle($graph);

        // Create the pie plot
        $p1 = new PiePlotC($data);
        $p1->SetStartAngle(180);
        $p1->SetSliceColors($color_array);

        // nasconde i label
        $p1->value->Show(false);

        // Set color for mid circle
        $p1->SetMidColor('white');

        $p1->SetMidSize(0.8);

        if (isset($this->vars['tot'])) {
            $subtitle = 'Totale Rispondenti '.$this->vars['tot'];
            /*
            if (isset($this->vars['tot_nulled'])) {
                $subtitle .= ' Non rispondenti '.$this->vars['tot_nulled'];
            }
            $p1->title->Set($subtitle);
            $p1->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
            */

            $graph->title->Set($subtitle);
            $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
            if (isset($this->vars['mandatory']) && 'Y' != $this->vars['mandatory']) {
                if (isset($this->vars['tot_nulled'])) {
                    $subtitle1 = 'Non rispondenti '.$this->vars['tot_nulled'];
                    $graph->subtitle->Set($subtitle1);
                    $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
                }
            }
        }

        $footer_txt = 'Media '.number_format($data[0], 2);
        $graph->footer->center->Set($footer_txt);
        $graph->footer->center->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
        $y = $this->vars['height'] / 2 - 8; // 8 è il font_size

        $graph->footer->SetMargin(0, 0, $y);

        // con 0 metto al centro la percentuale
        $p1->SetLabelPos(0);

        // Add plot to pie graph
        $graph->Add($p1);

        $this->graph = $graph;

        return $this;
    }
}
