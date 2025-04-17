<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class PieAvgAction {
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart):Graph {
        $labels = $answers->toCollection()->pluck('label')->all();

        // $this->vars['footer'] = 'Media: '.round((float) $this->data->toCollection()->avg('value'), 2);

        $data = $answers->toCollection()->pluck('value')->all();

        // dddx($answers);
        // Cannot access offset 'avg' on mixed.

        /* @var ModelContract $first_data */
        // $first_data = $answers->first();
        // if (isset($first_data->avg)) {
        //    $data = $answers->toCollection()->pluck('avg')->all();
        // }
        // dddx($data);
        if (isset($chart->max)) {
            $sum = collect($data)->sum();
            $other = $chart->max - $sum;
            // $other = $chart->max - $chart->avg;
            if ($other > 0.01) {
                // $color_array[1] = 'white';
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt ?? 'answer_value_no_txt';
                if (2 === \count($labels) && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $chart->answer_value_txt;
                }
            }
            // $data = [$chart->avg, $other];
        }

        // A new pie graph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        // $graph = $this->applyGraphStyle($graph);
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create the pie plot
        $p1 = new PiePlotC($data);
        $p1->SetStartAngle(180);

        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $chart->list_color);

        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@0.6';
        }
        // dddx($color_array);
        $p1->SetSliceColors($color_array);

        // nasconde i label
        $p1->value->Show(false);

        // Set color for mid circle
        $p1->SetMidColor('white');

        // $p1->SetMidSize(0.8);
        $p1->SetMidSize($chart->plot_perc_width / 100);

        $graph->title->Set($chart->title);
        $graph->title->SetFont($chart->font_family, $chart->font_style, 11);

        $graph->subtitle->Set($chart->subtitle);
        $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);

        // 150    Cannot cast mixed to float.
        $footer_txt = 'Media N.D.';
        if (\is_array($data) && isset($data[0]) && \is_numeric($data[0])) {
            // $footer_txt = 'Media '.number_format((float) $chart->avg, 2);
            $footer_txt = 'Media '.number_format((float) $data[0], 2);
        }

        $graph->footer->center->Set($footer_txt);
        $graph->footer->center->SetFont($chart->font_family, $chart->font_style, $chart->font_size);

        // posiziona al centro del pie
        $y = $chart->height / 2 - 8; // 8 è il font_size
        $graph->footer->SetMargin(0, 0, $y);

        // con 0 metto al centro la percentuale
        $p1->SetLabelPos(0);

        // Add plot to pie graph
        $graph->Add($p1);

        return $graph;
    }
}
