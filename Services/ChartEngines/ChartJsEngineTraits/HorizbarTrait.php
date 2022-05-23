<?php
/**
 * @link https://www.larashout.com/laravel-collection-using-tojson-method
 * @link https://codepen.io/k-sav/pen/PXxywK
 */

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

trait HorizbarTrait {
    /**
     * Undocumented function.
     */
    public function horizbar1(): self {
        //$view = 'chart::'.(inAdmin()?'admin.':'').'chartjs.'.__FUNCTION__;

        $labels=$this->data->pluck('label')->all();
        $data=$this->data->pluck('value')->all();
        //dddx(['data'=>$this->data]);
        $view = 'chart::chartjs.'.__FUNCTION__;
        //$view.='.1';
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
            'labels'=>$labels,
            'data'=>$data,
        ];

        //dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        exit($html);

        return $this;
    }
}
