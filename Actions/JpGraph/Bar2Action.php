<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class Bar2Action
{
    use QueueableAction;

    public function execute(DataCollection $answers, ChartData $chart): Graph
    {
        // https:// jpgraph.net/features/src/show-example.php?target=new_bar1.php
        // $graph = $this->getGraph();
        // dddx($answers);
        $graph = app(GetGraphAction::class)->execute($chart);
        // dddx($graph);
        // $graph->SetScale('textlin',$chart->min,$chart->max);

        // $graph->SetScale('textlin');

        $graph->img->SetMargin(50, 50, 50, 100);
        // dddx(debug_backtrace());
        // dddx($answers);
        $labels = $answers->toCollection()->pluck('label')->all();
        $datay = $answers->toCollection()->pluck('value')->all();
        $datay1 = $answers->toCollection()->pluck('value1')->all();

        // dddx([$labels, $datay, $datay1]);
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
        // dddx(array_flip($datay));

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->yscale->ticks->SupressZeroLabel(false);

        // Create the bar plots
        $colors = explode(',', $chart->list_color);
        $bplot = [];

        $i = 0;
        foreach ($datay as $k => $v) {
            $tmp = new BarPlot($v);
            // $tmp = $this->applyPlotStyle($tmp);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);
            $tmp->SetColor($colors[$i]);
            $tmp->SetFillColor($colors[$i].'@'.$chart->transparency); // trasparenza da 0 a 1
            // $tmp->SetFillColor($colors[$k]);

            if (isset($chart->legend)) {
                $str = $chart->legend[$k] ?? '--no set';
                $tmp->SetLegend($str);
            }

            $bplot[] = $tmp;
            ++$i;
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
        $delta = ($chart->width - 100) / \count($datay1);
        foreach ($datay1 as $i => $v) {
            $txt = new Text($v.'');

            $x = 50 + ($delta * $i) + ($delta / 3);

            $txt->SetPos($x, 25);

            // dddx($txt);

            $graph->AddText($txt);
        }

        return $graph;
    }
}
