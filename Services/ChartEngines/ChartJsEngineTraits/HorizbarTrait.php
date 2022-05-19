<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

trait HorizbarTrait {
    /**
     * Undocumented function.
     */
    public function horizbar1(): self {
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
        ];

        $out = view()->make($view, $view_params);
        $html = $out->render();
        exit($html);

        return $this;
    }
}