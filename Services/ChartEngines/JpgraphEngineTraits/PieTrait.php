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
        }

        // A new pie graph
        $graph = new PieGraph($this->width, $this->height, 'auto');
        // $graph = $this->getGraph();
        $graph = $this->applyGraphStyle($graph);

        // Create the pie plot
        $p1 = new PiePlotC($data);
        $p1->SetSliceColors(explode(',', $this->vars['list_color']));

        $p1->SetLegends($labels);
        $graph->legend->SetPos(0.5,0.98,'center','bottom');

        // Enable and set policy for guide-lines. Make labels line up vertically
        $p1->SetGuideLines(true, false);
        $p1->SetGuideLinesAdjust(1.5);

        // Use percentage values in the legends values (This is also the default)
        $p1->SetLabelType(PIE_VALUE_PER);
        $p1->value->Show();

        $p1->SetMidSize(0.8);

        $mandatory = $this->vars['mandatory'];
        if (is_null($this->vars['mandatory'])) {
            $mandatory = 'null';
        }

        $graph->title->Set($this->vars['title']);
        $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
 
        $graph->subtitle->Set($this->vars['subtitle']);
        $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        // Label font and color setup
        $p1->value->SetFont(FF_ARIAL, FS_BOLD, 10);
        $p1->value->SetColor('black');

        // Setup the title on the center circle
        $p1->midtitle->Set('');
        $p1->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);
        $p1->value->SetFormat('%2.1f%%');

        // Set color for mid circle
        $p1->SetMidColor('white');

        // Add plot to pie graph
        $graph->Add($p1);

        $this->graph = $graph;

        return $this;
    }

    public function pieAvg(): self {
        //$this->vars['subtitle']='nnn';
        //$this->vars['footer']='media';
        $labels = $this->data->pluck('label')->all();

        $this->vars['footer']='Media: '.round($this->data->avg('value'),2);

        $data = $this->data->pluck('value')->all();
        if (isset($this->data->first()['avg'])) {
            $data = $this->data->pluck('avg')->all();
        }

        $color_array = explode(',', $this->vars['list_color']);
        if (isset($this->vars['max'])) {
            $sum = collect($data)->sum();
            $other = $this->vars['max'] - $sum;
            if ($other > 0.01) {
                // $color_array[1] = 'white';
                $data[] = $other;
                $labels[] = $this->vars['answer_value_no_txt'] ?? 'answer_value_no_txt';
                if (2 === \count($labels) && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $this->vars['answer_value_txt'];
                }
            }
        }

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

        $graph->title->Set($this->vars['title']);
        $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
 
        $graph->subtitle->Set($this->vars['subtitle']);
        $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        
        $footer_txt = 'Media '.number_format((float) $data[0], 2);
        $graph->footer->center->Set($footer_txt);
        $graph->footer->center->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);

        // posiziona al centro del pie
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
