<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Illuminate\Support\Str;

/**
 * Undocumented trait.
 */
trait CommonTrait
{
    /**
     * Undocumented function.
     */
    public function applyGraphStyle(Graph $graph): Graph
    {
        $style = $this->vars;

        // Nice shadow
        $graph->SetShadow();

        $graph->SetBox($style['show_box']);

        $graph->footer->right->SetFont($style['font_family'], $style['font_style']);
        // $graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);

        return $graph;
    }

    public function applyGraphXStyle(Axis $xaxis): void
    {
        $style = $this->vars;
        $xaxis->SetFont($style['font_family'], $style['font_style'], $style['font_size']);
        $xaxis->SetLabelAngle($style['x_label_angle']);
        // Some extra margin looks nicer
        $xaxis->SetLabelMargin($style['x_label_margin']);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle(Axis $yaxis): void
    {
        $style = $this->vars;
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        $yaxis->scale->SetGrace($style['y_grace']);
        // dddx($style['yaxis_hide']);
        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        if (null == $style['yaxis_hide'] || 0 == $style['yaxis_hide']) {
            $yaxis->Hide();
        }

        $yaxis->HideZeroLabel();
        $yaxis->HideLine(false);
        $yaxis->HideTicks(false, false);
    }

    public function applyPlotStyle_old(BarPlot $plot): BarPlot
    {
        $style = $this->vars;
        // $plot->SetFillColor($style['color']);
        $plot->SetFillColor($style['color'] . '@' . $this->vars['transparency']); // trasparenza, da 0 a 1

        // $bplot->SetShadow('darkgreen', 1, 1);
        // dddx([get_defined_vars(), $this->vars]);

        $plot->SetColor($style['color']);

        // You can change the width of the bars if you like
        $plot->SetWidth($style['plot_perc_width'] / 100);
        // $bplot->SetWidth(0.5);

        // We want to display the value of each bar at the top
        // se tolto non mostra i valori
        if (null == $style['plot_value_show'] || 0 == $style['plot_value_show']) {
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
            case 3:
                $plot->value->SetFormat('%.0f');
                break;
            default:
                $plot->value->SetFormat('%.1f &#37;');
        }

        // Center the values in the bar
        if (null == $style['plot_value_pos'] || 0 == $style['plot_value_pos']) {
            $plot->SetValuePos('center');
        }

        $plot->value->setAngle($style['x_label_angle']);
        // $plot->value->setAngle(50);

        return $plot;
    }

    public function applyPlotStyle(BarPlot $plot): BarPlot
    {
        // dddx($this);
        $style = $this->vars;
        // $plot->SetFillColor(['red','red','red','red','red', 'green']);

        $colors = [];
        // dddx(collect($this->vars['chart_type']));

        foreach ($this->data as $k => $d) {
            if (Str::contains($this->vars['chart_type'], 'horiz')) {
                // cannot access offset 'label' on mixed
                if (\is_array($this->data[$k])) {
                    if ('NR' == $this->data[$k]['label']) {
                        $list_color = explode(',', $this->vars['list_color']);
                        $colors[$k] = $list_color[0] . '@' . $this->vars['transparency'];
                    } else {
                        $colors[$k] = $style['color'] . '@' . $this->vars['transparency'];
                    }
                }
            } else {
                $colors = $style['color'] . '@' . $this->vars['transparency'];
            }
        }

        $plot->SetFillColor($colors); // trasparenza, da 0 a 1

        // $plot->SetFillColor($this->data[5]['color'].'@'.$this->vars['transparency']); // trasparenza, da 0 a 1

        // $bplot->SetShadow('darkgreen', 1, 1);
        // dddx([get_defined_vars(), $this->vars]);

        $plot->SetColor($style['color']);

        // You can change the width of the bars if you like
        $plot->SetWidth($style['plot_perc_width'] / 100);
        // $plot->SetWidth(10);

        // We want to display the value of each bar at the top
        // se tolto non mostra i valori
        if (null == $style['plot_value_show'] || 0 == $style['plot_value_show']) {
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
            case 3:
                $plot->value->SetFormat('%.0f');
                break;
            default:
                $plot->value->SetFormat('%.1f &#37;');
        }

        // Center the values in the bar
        if (null == $style['plot_value_pos'] || 0 == $style['plot_value_pos']) {
            $plot->SetValuePos('center');
        }

        $plot->value->setAngle($style['x_label_angle']);
        // $plot->value->setAngle(50);

        return $plot;
    }

    public function setTitle(string $title): self
    {
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
