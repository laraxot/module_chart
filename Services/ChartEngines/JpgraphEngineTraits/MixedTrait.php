<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Chart\Models\MixedChart;
use Modules\Quaeris\Services\LimeModelService;
use Modules\Xot\Services\FileService;


trait MixedTrait {
    public function mixed(string $id): self {
        $map = [
            'mixed_chart' => 'Modules\Chart\Models\MixedChart',
        ];
        Relation::morphMap($map);

        $mixed = MixedChart::findOrFail($id);
        $charts = $mixed->charts()->get();
        

        if (0 === $charts->count()) {
            $sql = rowsToSql($mixed->charts());

            throw new Exception('charts vuoto sql:['.$sql.']');
        }

        $imgs = [];
        foreach ($charts as $k => $chart) {
            $vars = $this->vars;
            $vars = array_merge($vars, $chart->toArray());

            if (Str::startsWith($vars['type'], 'mixed')) {
                throw new Exception('crei un loop infinito['.__LINE__.']['.__FILE__.']');
            }

            if ($k > 0) {
                $vars['title'] = 'no_title';
                $vars['subtitle'] = '';
                $vars['footer'] = '';
            }

            $tmp = LimeModelService::make()->mergeVars($vars)->getImg();

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
