<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

trait BarTrait {
    public function bar2(): self {
        $labels = $this->data->pluck('label')->all();
        $data = $this->data->pluck('value')->all();

        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
            'labels' => $labels,
            'data' => $data,
        ];

        //dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        exit($html);

        return $this;
    }
}
