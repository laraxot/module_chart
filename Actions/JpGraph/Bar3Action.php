<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\AccBarPlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Bar3Action
{
    use QueueableAction;

    /**
     * ---.
     *
     * @param DataCollection<AnswerData>
     */
    public function execute(DataCollection $answers, ChartData $chart): Graph
    {
        $graph = app(GetGraphAction::class)->execute($chart);
        $graph->img->SetMargin(50, 50, 50, 100);
        $labels = $answers->toCollection()->pluck('label')->all();
        $datay = $answers->toCollection()->pluck('value')->all();
        $datay1 = $answers->toCollection()->pluck('value1')->all();
        if (! isset($datay[0])) {
            $datay1 = [0 => 0];
            $datay[0] = [0 => 0];
            $datay[1] = [1 => 0];
        }

        if (! \is_array($datay[0])) {
            $datay = [$datay];
        } else {
            $tmp = [];
            foreach ($datay as $arr) {
                if (\is_array($arr)) {
                    foreach ($arr as $k => $v) {
                        $tmp[$k][] = $v;
                    }
                }
            }
            $datay = $tmp;
        }

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
        $graph->yscale->ticks->SupressZeroLabel(false);

        // Create the bar plots
        $colors = explode(',', $chart->list_color);
        $bplot = [];
        $value_pos = ['bottom', 'top'];

        foreach ($datay as $k => $v) {
            $tmp = new BarPlot($v);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);

            $tmp->SetValuePos($value_pos[$k]);
            $tmp->SetColor($colors[$k]);
            $tmp->SetFillColor($colors[$k].'@'.$chart->transparency); // trasparenza da 0 a 1

            if (isset($chart->legend)) {
                $str = $chart->legend[$k] ?? '--no set';
                $tmp->SetLegend($str);
            }

            $bplot[] = $tmp;
        }

        // Create the grouped bar plot
        $gbplot = new AccBarPlot($bplot);
        $gbplot->SetWidth($chart->plot_perc_width / 100);
        // ...and add it to the graPH
        $graph->Add($gbplot);

        if (\count($datay) > 1) {
            // dddx($this->data->first()['title_type']);
            // dddx($this->vars['title']);
            $title = $chart->title;

            // $subtitle = 'Totale rispondenti';
            $graph->title->Set($title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }

        if (isset($chart->totali)) {
            $str = '';
            foreach ($chart->totali as $k => $v) {
                $str .= $k.' '.$v.' - ';
            }
            $graph->footer->center->Set($str);
            $graph->footer->center->SetFont($chart->font_family, $chart->font_style, 11);
        }

        // cifre sopra il grafico
        $delta = ($chart->width - 100) / \count($datay1);

        if (is_array($datay1)) {
            foreach ($datay1 as $i => $v) {
                $txt = new Text('');
                if (\is_array($v) && isset($v[0])) {
                    $txt = new Text($v[0].'');
                }
                $x = 50 + ($delta * $i) + ($delta / 3);
                $txt->SetPos($x, 20);
                $graph->AddText($txt);

                $txt2 = new Text('');
                if (\is_array($v) && isset($v[1])) {
                    $txt2 = new Text($v[1]);
                }
                $txt2->SetPos($x, 35);
                $graph->AddText($txt2);
            }
        }

        return $graph;
    }
}
