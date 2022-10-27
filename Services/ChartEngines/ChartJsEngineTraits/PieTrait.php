<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Illuminate\Support\Str;
use Modules\Chart\Services\ChartJsBuilder;

trait PieTrait {
    public function pie1(): self {
        $uuid = Str::uuid()->toString();
        $uuid = str_replace('-', '', $uuid);
        $uuid = substr($uuid, -8);

        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();

        $subtitle = 'Totale Rispondenti '.$this->vars['tot'];

        $chartjsbuilder = ChartJsBuilder::make();

        $chartjs = $chartjsbuilder
        ->name('c'.$uuid)
        ->type('pie')
        ->size(['width' => $this->vars['width'], 'height' => $this->vars['height']])
        ->labels($datax)
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => $datay,
            ],
        ])
        ->options(['responsive' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $subtitle,
                ], ], ]);

        $view = 'chart::chartjs.example';
        $view_params = compact('chartjs');
        $view_params['view'] = $view;
        $view_params['filename'] = 'prova123';

        // dddx($view_params);
        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html;

        return $this;
    }

    public function pieMonthBarWeekBarNoSi(): self {
        /**
         * @phpstan-var view-string
         */
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
        ];

        // dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html; // se non mostro js non viene elaborato

        return $this;
    }

    public function pieMonthBarWeekBar(): self {
        /**
         * @phpstan-var view-string
         */
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
        ];

        // dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html; // se non mostro js non viene elaborato

        return $this;
    }

    public function pieAvg(): self {
        // dddx($this);

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

        $uuid = Str::uuid()->toString();
        $uuid = str_replace('-', '', $uuid);
        $uuid = substr($uuid, -8);

        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();

        $chartjsbuilder = ChartJsBuilder::make();

        // Create the pie plot
        /*$p1 = new PiePlotC($data);
        $p1->SetStartAngle(180);
        $p1->SetSliceColors($color_array);

        // nasconde i label
        $p1->value->Show(false);

        // Set color for mid circle
        $p1->SetMidColor('white');

        $p1->SetMidSize(0.8);*/

        // dddx($this->vars['mandatory']);
        $mandatory = $this->vars['mandatory'];
        if (null === $this->vars['mandatory']) {
            $mandatory = 'null';
        }

        // dddx($this->vars);

        $subtitle = '';
        if (isset($this->vars['tot'])) {
            $subtitle = 'Totale Rispondenti '.$this->vars['tot']; // .' - ('.$mandatory.')';

            // $graph->title->Set($subtitle);
            // $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
            if ('Y' !== $this->vars['mandatory']) {
                if (isset($this->vars['tot_nulled'])) {
                    $subtitle1 = 'Non rispondenti '.$this->vars['tot_nulled'];
                    // $graph->subtitle->Set($subtitle1);
                    // $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
                }
            }
        }

        $footer_txt = 'Media '.number_format((float) $data[0], 2);

        // dddx([$subtitle, $footer_txt]);
        // $graph->footer->center->Set($footer_txt);
        // $graph->footer->center->SetFont($this->vars['font_family'], $this->vars['font_style'], $this->vars['font_size']);
        $y = $this->vars['height'] / 2 - 8; // 8 è il font_size

        // $graph->footer->SetMargin(0, 0, $y);

        // con 0 metto al centro la percentuale

        // Add plot to pie graph
        // $graph->Add($p1);

        $chartjs = $chartjsbuilder
        ->name('c'.$uuid)
        ->type('pie')
        ->size(['width' => $this->vars['width'], 'height' => $this->vars['height']])
        ->labels($datax)
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => $datay,
            ],
        ])
        ->options([
            'responsive' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $footer_txt.' / '.$subtitle,
                ],
            ],
        ]);

        $view = 'chart::chartjs.example';
        $view_params = compact('chartjs');
        $view_params['view'] = $view;
        $view_params['filename'] = 'prova123';

        // dddx($view_params);
        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html;

        return $this;
    }
}
