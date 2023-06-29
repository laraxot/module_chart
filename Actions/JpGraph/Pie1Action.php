<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Pie1Action
{
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph
    {
        $labels = $answers->toCollection()->pluck('label')->all();
        $data = $answers->toCollection()->pluck('value')->all();
        // dddx($chart->max);
        if (isset($chart->max)) {
            $sum = collect($data)->sum();
            $other = $chart->max - $sum;
            // dddx([$sum, $other, $this->vars['max']]);
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt;

                if (2 === \count($labels) && \strlen($labels[0]) < 3) {
                    $labels[0] = $chart->answer_value_txt;
                }
            }
        }

        // A new pie graph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        // $graph = $this->getGraph();
        // $graph = $this->applyGraphStyle($graph);
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create the pie plot
        $p1 = new PiePlotC($data);

        // $p1->SetSliceColors(explode(',', $chart->list_color));
        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
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
        $p1->SetMidSize($chart->plot_perc_width / 100);

        // $mandatory = $chart->mandatory;
        // if (null === $chart->mandatory) {
        //     $mandatory = 'null';
        // }

        $graph->title->Set($chart->title);
        $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        $graph->subtitle->Set($chart->subtitle);
        $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);

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

        return $graph;
    }
}
