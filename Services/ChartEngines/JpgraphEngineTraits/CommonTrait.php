<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Graph\Graph;

/**
 * Undocumented trait.
 */
trait CommonTrait {
    /**
     * Undocumented function.
     */
    public function applyGraphStyle(Graph $graph): Graph {
        $style = $this->vars;

        // Nice shadow
        $graph->SetShadow();

        $graph->SetBox($style['show_box']);

        $graph->footer->right->SetFont($style['font_family'], $style['font_style']);
        // $graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);

        return $graph;
    }

    public function applyGraphXStyle($xaxis) {
        $style = $this->vars;
        $xaxis->SetFont($style['font_family'], $style['font_style'], $style['font_size']);
        $xaxis->SetLabelAngle($style['x_label_angle']);
        // Some extra margin looks nicer
        $xaxis->SetLabelMargin($style['x_label_margin']);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle($yaxis) {
        $style = $this->vars;
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        $yaxis->scale->SetGrace($style['y_grace']);

        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        if (null === $style['yaxis_hide'] || 0 === $style['yaxis_hide']) {
            $yaxis->Hide();
        }

        $yaxis->HideZeroLabel();
        $yaxis->HideLine(false);
        $yaxis->HideTicks(false, false);
    }

    public function applyPlotStyle($plot) {
        $style = $this->vars;
        $plot->SetFillColor($style['color']);
        // $bplot->SetShadow('darkgreen', 1, 1);
        $plot->SetColor($style['color']);

        // You can change the width of the bars if you like
        $plot->SetWidth($style['plot_perc_width'] / 100);
        // $bplot->SetWidth(0.5);

        // We want to display the value of each bar at the top
        // se tolto non mostra i valori
        if (null === $style['plot_value_show'] || 0 === $style['plot_value_show']) {
            $plot->value->Show();
        }

        $plot->value->SetFont($style['font_family'], $style['font_style'], $style['font_size']);

        $plot->value->SetAlign('left', 'center');
        // colore del font che scrivi
        if (null !== $style['plot_value_color']) {
            $plot->value->SetColor($style['plot_value_color']);
        } else {
            $plot->value->SetColor('black', 'darkred');
        }

        // visualizza il risultato con % oppure no
        // $plot->value->SetFormat('%.2f &#37;');
        // 2f significa 2 cifre decimali, 1f solo una cifra decimale
        switch ($style['plot_value_format']) {
            case 1:
                $plot->value->SetFormat('%.1f &#37;');
              break;
            case 2:
                $plot->value->SetFormat('%.1f');
              break;
            default:
                $plot->value->SetFormat('%.1f &#37;');
        }

        // Center the values in the bar
        if (null === $style['plot_value_pos'] || 0 === $style['plot_value_pos']) {
            $plot->SetValuePos('center');
        }

        $plot->value->setAngle($style['x_label_angle']);
        // $plot->value->setAngle(50);

        return $plot;
    }

    public function setTitle(string $title): self {
        $style = $this->vars;
        // Set up the title for the graph
        // $graph->title->Set('Bar gradient with left reflection');
        // $this->graph->title->SetMargin(8);
        $this->graph->title->SetFont($style['font_family'], $style['font_style'], $style['font_size']);
        $this->graph->title->SetColor('darkblue');
        $this->graph->title->Set($title);

        return $this;
    }
}