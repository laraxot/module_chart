<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Illuminate\Support\Str;
use Modules\Chart\Models\MixedChart;
use Modules\Xot\Services\FileService;

trait MixedTrait {
    /**
     * Undocumented function.
     */
    public function mixed(string $id): self {
        // dddx($this);
        $mixed = MixedChart::findOrFail($id);

        $charts = $mixed->charts()->get(); // ->take(1);

        if (0 === $charts->count()) {
            $rows = $mixed->charts();
            // $sql = Str::replaceArray('?', $rows->getBindings(), $rows->toSql());
            $sql = str_replace('?', $rows->getBindings(), $rows->toSql());
            throw new \Exception('charts vuoto sql:['.$sql.']');
        }

        $imgs = [];
        foreach ($charts as $chart) {
            $vars = $this->vars;
            $vars = array_merge($vars, $chart->toArray());
            if (Str::startsWith($vars['type'], 'mixed')) {
                throw new \Exception('crei un loop infinito['.__LINE__.']['.__FILE__.']');
            }

            $vars['style_float'] = 'left';
            $vars['style_clear'] = 'none';

            $tmp = $vars['callback']->mergeVars($vars)->getImg();

            $imgs[] = [
                'img_path' => FileService::fixPath(public_path($tmp)),
                'width' => $vars['width'],
                'height' => $vars['height'],
            ];
        }

        $this->imgs = $imgs;

        return $this;
    }
}
