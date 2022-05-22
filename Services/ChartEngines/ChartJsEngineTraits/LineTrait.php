<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

trait LineTrait {
    public function line1() {
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
        ];

        //dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        exit($html);

        return $this;
    }
}
