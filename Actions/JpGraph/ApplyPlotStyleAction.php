<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Plot\BarPlot;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class ApplyPlotStyleAction {
    use QueueableAction;

    public function execute(BarPlot $plot, ChartData $data): BarPlot {
        $colors = [];

        // $plot->SetFillColor($colors); // trasparenza, da 0 a 1

        // $plot->SetFillColor($this->data[5]['color'].'@'.$this->vars['transparency']); // trasparenza, da 0 a 1
        $plot->SetFillColor($data->list_color ?? 'red@'.$data->transparency); // trasparenza, da 0 a 1

        // $bplot->SetShadow('darkgreen', 1, 1);
        // dddx([get_defined_vars(), $this->vars]);

        $plot->SetColor($data->list_color ?? 'red');

        // You can change the width of the bars if you like
        $plot->SetWidth($data->plot_perc_width / 100);
        // $plot->SetWidth(10);

        // We want to display the value of each bar at the top
        // se tolto non mostra i valori
        if (null == $data->plot_value_show || 0 == $data->plot_value_show) {
            $plot->value->Show();
        }

        $plot->value->SetFont($data->font_family, $data->font_style, $data->font_size);

        $plot->value->SetAlign('left', 'center');
        // colore del font che scrivi
        if (null !== $data->plot_value_color) {
            $plot->value->SetColor($data->plot_value_color);
        } else {
            $plot->value->SetColor('black', 'darkred');
        }

        // visualizza il risultato con % oppure no
        // $plot->value->SetFormat('%.2f &#37;');
        // 2f significa 2 cifre decimali, 1f solo una cifra decimale
        switch ($data->plot_value_format) {
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
        if (null == $data->plot_value_pos || 0 == $data->plot_value_pos) {
            $plot->SetValuePos('center');
        }

        $plot->value->setAngle($data->x_label_angle);
        // $plot->value->setAngle(50);

        return $plot;
    }
}
