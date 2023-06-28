<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Illuminate\Support\Str;
use Modules\Chart\Services\ChartJsBuilder;

trait BarTrait {
    public function bar2(): self {
        $uuid = Str::uuid()->toString();
        $uuid = str_replace('-', '', $uuid);
        $uuid = substr($uuid, -8);

        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();

        $chartjsbuilder = ChartJsBuilder::make();

        $chartjs = $chartjsbuilder
        // attenzione: rand andrà sostuito con un id univoco per il canvas
        // ho provato con uuid ma vedo che non funziona. forse troppo lungo
        ->name('c'.$uuid)
        // a seconda del type
        ->type('bar')
        ->size(['width' => $this->vars['width'], 'height' => $this->vars['height']])
        ->labels($datax)
        ->datasets([
            [
                'label' => 'Anwers',
                'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                'data' => $datay,
            ],
        ])
        ->options([
            'responsive' => false,
            'indexAxis' => 'x',
            'elements' => [
                'bar' => [
                    'borderWidth' => 2,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Totale Rispondenti: '.$this->vars['tot'],
                ],
            ],
        ]);

        $view = 'chart::chartjs.example';
        $view_params = compact('chartjs');
        $view_params['view'] = $view;
        $view_params['filename'] = 'prova123';

        // dddx($view_params);
        $out = view($view, $view_params);
        $html = $out->render();
        echo $html;

        return $this;
    }
}
