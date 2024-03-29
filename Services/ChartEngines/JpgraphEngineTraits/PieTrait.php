<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Modules\Xot\Contracts\ModelContract;

trait PieTrait {
    /**
     * Undocumented function.
     * https://jpgraph.net/download/manuals/chunkhtml/ch16.html.
     * https://jpgraph.net/download/manuals/chunkhtml/example_src/piecex2.html.
     */
    public function pie1(): self {
        $labels = $this->data->toCollection()->pluck('label')->all();
        $data = $this->data->toCollection()->pluck('value')->all();
        // dddx([$this->data, $data, $this->vars]);
        if (isset($this->vars['max'])) {
            $sum = collect($data)->sum();
            $other = $this->vars['max'] - $sum;
            // dddx([$sum, $other, $this->vars['max']]);
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $this->vars['answer_value_no_txt'];

                if (2 === \count($labels) && \strlen($labels[0]) < 3) {
                    $labels[0] = $this->vars['answer_value_txt'];
                }
            }
        }
        // dddx([$data, $other, $labels]);
        // A new pie graph
        $graph = new PieGraph($this->width, $this->height, 'auto');
        // $graph = $this->getGraph();
        $graph = $this->applyGraphStyle($graph);

        // Create the pie plot
        $p1 = new PiePlotC($data);

        // $p1->SetSliceColors(explode(',', $this->vars['list_color']));
        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $this->vars['list_color']);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$this->vars['transparency'];
        }
        $p1->SetSliceColors($color_array);

        $p1->SetLegends($labels);
        // $graph->legend->SetPos(0.5,0.98,'center','bottom');

        // Enable and set policy for guide-lines. Make labels line up vertically
        $p1->SetGuideLines(true, false);
        $p1->SetGuideLinesAdjust(1.5);

        // Use percentage values in the legends values (This is also the default)
        $p1->SetLabelType(PIE_VALUE_PER);
        $p1->value->Show();

        // $p1->SetMidSize(0.8);
        $p1->SetMidSize($this->vars['plot_perc_width'] / 100);

        $mandatory = $this->vars['mandatory'];
        if (null === $this->vars['mandatory']) {
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
        // $this->vars['subtitle']='nnn';
        // $this->vars['footer']='media';
        $labels = $this->data->toCollection()->pluck('label')->all();

        $this->vars['footer'] = 'Media: '.round((float) $this->data->toCollection()->avg('value'), 2);

        $data = $this->data->toCollection()->pluck('value')->all();
        // Cannot access offset 'avg' on mixed.

        /** @var ModelContract $first_data */
        $first_data = $this->data->first();
        if (isset($first_data->avg)) {
            $data = $this->data->toCollection()->pluck('avg')->all();
        }

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

        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $this->vars['list_color']);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@0.6';
        }
        $p1->SetSliceColors($color_array);

        // nasconde i label
        $p1->value->Show(false);

        // Set color for mid circle
        $p1->SetMidColor('white');

        // $p1->SetMidSize(0.8);
        $p1->SetMidSize($this->vars['plot_perc_width'] / 100);

        $graph->title->Set($this->vars['title']);
        $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        $graph->subtitle->Set($this->vars['subtitle']);
        $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);

        // 150    Cannot cast mixed to float.
        $footer_txt = 'Media N.D.';
        if (\is_array($data) && isset($data[0]) && \is_numeric($data[0])) {
            $footer_txt = 'Media '.number_format((float) $data[0], 2);
        }
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
