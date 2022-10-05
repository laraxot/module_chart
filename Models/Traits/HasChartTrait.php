<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Chart\Models\Chart;

trait HasChartTrait {
    public function chart(): MorphOne {
        return $this->morphOne(Chart::class, 'post')

        ->withDefault([
            'x_label_angle' => '0',
            'color' => '#d60021',
            'list_color' => 'darkgreen,darkgray',
        ]);
    }
}
